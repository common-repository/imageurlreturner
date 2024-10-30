<?php
/*
Plugin Name: ThumbnailImageURLReturner
Plugin URI: http://coralbark.net/blog/?p=127
Description: When an XML-RPC client upload images, this plugin returns the URLs of the resized images that WP automatically creates
Version: 0.2
Author: Jon Levell
Author URI: http://www.coralbark.net/
License: GPL2
*/

/*  Copyright 2010  Jon Levell  (email : wordpress_plugins@coralbark.net )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Use this filter to get the metadata for a filename */
add_filter('wp_generate_attachment_metadata', 'ImageURLReturner_storemetadata', 10, 2);

/* Use this filter to add the urls to the returned data */
add_filter('wp_handle_upload', 'ImageURLReturner_handleupload', 10, 1);

//global array of file => metadata
global $ImageURLReturner_metadata_array;
$ImageURLReturner_metadata_array = array();

function ImageURLReturner_storemetadata( $metadata, $attachment_id )
{
   global $ImageURLReturner_metadata_array;
   
   $filename = basename($metadata['file']);
   
   $ImageURLReturner_metadata_array[$filename] = $metadata;
        
   return $metadata;
}


function ImageURLReturner_handleupload($returneddata)
{
   global $ImageURLReturner_metadata_array;

   //We work out the filename from the url as if it has the same
   //name as a pre-existing file, the url we get has been renamed
   //but the file is still the old filename
   $filename = basename($returneddata['url']);

   if(   isset($ImageURLReturner_metadata_array[$filename])
      && is_array($ImageURLReturner_metadata_array[$filename]) ) {
      $metadata = $ImageURLReturner_metadata_array[$filename];

                //Get the URLs for each image we generated   
      if(    isset($metadata['sizes'])
          && is_array($metadata['sizes']) ) {
         foreach( $metadata['sizes'] as $size => $size_data ) {
            if( isset($size_data['file']) ) {
               $resized_url  =  str_replace(  $filename, 
                                              $size_data['file'],
                                              $returneddata[ 'url' ]) ;
               $returneddata[ $size.'_url' ] = $resized_url;
            }
         }
      }
      //Now remove the metadata from the global array so we don't mem leak
      unset($ImageURLReturner_metadata_array[$filename]);      
   }

   return $returneddata;
}

?>

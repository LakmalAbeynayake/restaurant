<?php
/**
* this is image manipulation librarie class
*/
class Image_Manipulation
{
	
    public function image_config($image_name='')
    {
        $config['upload_path'] = './thems/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '800';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = $image_name;
        return $config;
    }

    public function image_thumb($source_image='',$width='', $height='')
    {
        $config['image_library'] 	= 'gd2';
        $config['source_image'] 	= './thems/uploads/'.$source_image.'';
        $config['new_image'] 		= './thems/uploads/thumbs/';
        $config['create_thumb'] 	= TRUE;
        $config['maintain_ratio'] 	= TRUE;
        $config['quality'] 			= '60%';
        $config['width'] 			= $width;
        $config['height'] 			= $height;
        return $config;
    }

}
?>
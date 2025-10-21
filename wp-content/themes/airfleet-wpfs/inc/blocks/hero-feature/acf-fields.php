<?php
add_action('acf/init', function () {
  if( function_exists('acf_add_local_field_group') ):
  acf_add_local_field_group([
    'key' => 'group_hero_feature','title' => 'Hero Feature',
    'fields' => [
      ['key'=>'field_layout','label'=>'Layout','name'=>'layout','type'=>'select','choices'=>['text_left'=>'Text left / Image right','text_right'=>'Text right / Image left'],'default_value'=>'text_left','ui'=>1],
      ['key'=>'field_headline','label'=>'Headline','name'=>'headline','type'=>'text'],
      ['key'=>'field_subheadline','label'=>'Subheadline','name'=>'subheadline','type'=>'text'],
      ['key'=>'field_summary','label'=>'Summary (short)','name'=>'summary','type'=>'textarea','rows'=>3],
      ['key'=>'field_body','label'=>'Body (long)','name'=>'body','type'=>'wysiwyg','tabs'=>'visual','toolbar'=>'basic','media_upload'=>0],
      ['key'=>'field_cta_group','label'=>'Primary Button','name'=>'cta_group','type'=>'group','sub_fields'=>[
        ['key'=>'field_cta_label','label'=>'Label','name'=>'label','type'=>'text'],
        ['key'=>'field_cta_url','label'=>'URL','name'=>'url','type'=>'url']
      ]],
      ['key'=>'field_image','label'=>'Foreground Image','name'=>'image','type'=>'image','return_format'=>'array','preview_size'=>'medium'],
      ['key'=>'field_image_alt','label'=>'Image Alt','name'=>'image_alt','type'=>'text']
    ],
    'location' => [[['param'=>'block','operator'=>'==','value'=>'acf/hero-feature']]],
    'position'=>'normal','style'=>'seamless','active'=>true
  ]);
  endif;
});

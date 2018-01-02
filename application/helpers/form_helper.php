<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2018/1/2
 * 
 */
if (!function_exists('filed_show')) {

    function filed_show($filed) {
        $string = '';
        foreach ($filed as $key => $value) {
            switch($value['type']) {
                case 'text':
                    $string .= '<div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">'.$value['title'].'</label>
                <div class="col-sm-10">
                    <input type="text" class="form-input-mid" id="inputEmail3" placeholder="'.$value['title'].'" name="'.$key.'"';
                     if (isset($value['checked']) && $value['checked'] == '') {
                         $string .='"value"="'.$value['checked'].'"';
                     }
                    $string .=' >
                </div>
            </div>';
                    break;
                case 'longtext':
                    break;
                case 'image':
                    $string .= '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">'.$value['title'].'</label>
                <div class="col-sm-10">
                    <input id="'.$key.'_upload" name="'.$key.'_upload" type="file" multiple="true">
                    <input type="hidden" name="'.$key.'" id="'.$key.'" value="">
                    <img width="200" height="200" src="" id="'.$key.'_src" />
                </div>
            </div>';
                    break;
                case 'image_group':
                    break;
                case 'select':
                    $string .= '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">'.$value['title'].'</label>
                <div class="col-sm-10">
                    <select class="form-select" name="'.$key.'" id="'.$key.'">';
                        foreach ($value['data'] as $k=> $v) {
                            if (isset($value['checked']) && $v['val'] == $value['checked']) {
                                $string .= '<option checked="checked" value="'.$v['val'].'">'.$v['label'].'</option>';
                            } else {
                                $string .= '<option value="'.$v['val'].'">'.$v['label'].'</option>';
                            }
                        }
                $string .='
                    </select>
                </div>
            </div>';
                    break;
                case 'single':
                    $string .= '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">'.$value['title'].'</label>
                <div class="col-sm-10">';
                    foreach($value['data'] as $k => $v) {
                        if (isset($value['checked']) && $v['val'] == $value['checked']) {
                            $string .= '<div><input type="radio" checked="checked" name="'.$key.'" value="'.$v['val'].'">'.$v['label'].'</div>';
                        } else {
                            $string .= '<div><input type="radio" name="'.$key.'" value="'.$v['val'].'">'.$v['label'].'</div>';
                        }
                    }
                $string .= '
                </div>
            </div>';
                    break;
                case 'multi':
                    $string .= '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">'.$value['title'].'</label>
                <div class="col-sm-10">';
                    foreach($value['data'] as $k => $v) {
                        if (isset($value['checked']) && $v['val'] == $value['checked']) {
                            $string .= '<div><input type="checkbox" checked="checked" name="'.$key.'[]" value="'.$v['val'].'">'.$v['label'].'</div>';
                        } else {
                            $string .= '<div><input type="checkbox" name="'.$key.'[]" value="'.$v['val'].'">'.$v['label'].'</div>';
                        }
                    }
                    $string .= '
                </div>
            </div>';
                    break;
                case 'fulltext':
                    $string .='<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">'.$value['title'].'</label>
                <div class="col-sm-10">
                    <textarea class="form-textarea" name="'.$key.'" id="'.$key.'"></textarea>
                </div>
            </div>';
                    break;
            }
        }
        return $string;
    }


}
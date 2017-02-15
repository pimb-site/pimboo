<?php namespace App\Http\Controllers;
use Illuminate\View\View;
use Storage;
/**
 * Created by PhpStorm.
 * User: sasa
 * Date: 12.01.2017
 * Time: 10:12
 */

class imageController extends Controller
{
    public function getUpload() {
        if(\Auth::guest()) {
            return view('auth/login');
        } else return view('upload');
    }

    public function getUploadForm($id) {
        if(\Auth::guest()) return view('auth/login');
        else return view('uploadForm', ['id' => $id]);
    }

    public function postUpload() {
        if(\Auth::guest()) return view('auth/login');
        $image = \Input::get('image');
        $img = str_replace('data:image/jpeg;base64,', '', $image);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        if(!file_exists("temp/".\Session::getId())) {
            mkdir("temp/".\Session::getId());
        }
        $temp_file = \Session::getId()."/".uniqid() . '.jpeg';
        $file = "temp/".$temp_file;
        $success = file_put_contents($file, $data);

        if($success) {
            return \Response::json(['success' => true, 'file' => $temp_file]);
        }
    }

    public function postUploadEnd() {
        if(\Auth::guest()) return view('auth/login');

        $input = \Input::all();

        $validator = \Validator::make(
            array(
                'Flip Cards Title' => $input['form_flip']['form_flip_cards_title'],
                'Flip Cards Description' => $input['form_flip']['form_description'],
                'Flip Cards Footer' => $input['form_flip']['form_footer'],
                'Flip Cards Photo' => $input['form_flip']['form_photo']
            ),
            array(
                'Flip Cards Title' => 'required',
                'Flip Cards Description' => 'required',
                'Flip Cards Footer' => 'required',
                'Flip Cards Photo' => 'required'
            )
        );

        if (!$validator->fails())
        {
            foreach ($input['flip_cards'] as $key => $value) {
                $validator_cards = \Validator::make(
                    array(
                        'Item Title' => $value['form_item_title'],
                        'Front Card' => $value['img_src1'],
                        'Back Card' => $value['img_src2']
                    ),
                    array(
                        'Item Title' => 'required',
                        'Front Card' => 'required',
                        'Back Card' => 'required'
                    )
                );

                if ($validator_cards->fails()) {
                    return \Response::json(['success' => false, 'errors' => $validator_cards->errors()]);
                }
            }

            if(!$validator_cards->fails()) {
                $errors_array = array();
                if(!file_exists('temp/'.$input['form_flip']['form_photo'])) $errors_array[] = 'Wrong photo link';
                foreach ($input['flip_cards'] as $key => $value) {
                    if(!file_exists('temp/'.$value['img_src1'])) $errors_array[] = 'Wrong front image link';
                    if(!file_exists('temp/'.$value['img_src2'])) $errors_array[] = 'Wrong back image link';
                    if(count($errors_array) > 0) return \Response::json(['success' => false, 'errors' => $errors_array]);
                }

                if(count($errors_array) == 0) {
                    $content = array();
                    $uniqid3 = uniqid();
                    copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid3.'.jpeg');
                    unlink('temp/'.$input['form_flip']['form_photo']);
                    foreach ($input['flip_cards'] as $key => $value) {
                        $uniqid1 = uniqid();
                        $uniqid2 = uniqid();
                        copy('temp/'.$value['img_src1'], 'uploads/'.$uniqid1.'.jpeg');
                        copy('temp/'.$value['img_src2'], 'uploads/'.$uniqid2.'.jpeg');
                        unlink('temp/'.$value['img_src1']);
                        unlink('temp/'.$value['img_src2']);
                        $content[] = [
                            'item_title' => $value['form_item_title'],
                            'front_card' => $uniqid1.".jpeg",
                            'back_card' => $uniqid2.".jpeg",
                        ];
                    }
                    \DB::insert('insert into posts (user_id, description_title, description_text, description_footer, content, description_image) values (?, ?, ?, ?, ?, ?)',
                        [\Auth::user()->id, $input['form_flip']['form_flip_cards_title'], $input['form_flip']['form_description'], $input['form_flip']['form_footer'], serialize($content), $uniqid3.".jpeg"]);
                    return \Response::json(['success' => true, 'text' => 'Saved successfully!']);
                }
            }
        } else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
    }

    public function viewFlipCards() {
        $contentflip = \DB::select('select * from posts');
        return view('view_flip_cards', ['contentflip' => $contentflip]);
    }


    public function viewID($id) {
        $content = \DB::select('select * from posts where id = ?', [$id]);
        return view('viewID', ['content' => $content[0]]);
    }
}
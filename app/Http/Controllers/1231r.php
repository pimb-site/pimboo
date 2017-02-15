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
        return view('upload');
    }

    public function getUploadForm($id) {
        return view('uploadForm', ['id' => $id]);
    }

    public function postUpload() {

        $image = \Input::get('image');
        $img = str_replace('data:image/jpeg;base64,', '', $image);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        if(!file_exists("temp/".\Session::getId())) {
            mkdir("temp/".\Session::getId());
        }
        $file = "temp/".\Session::getId()."/".uniqid() . '.jpeg';
        $success = file_put_contents($file, $data);

        if($success) {
            return \Response::json(['success' => true, 'file' => asset($file)]);
        }
    }

    public function postUploadEnd() {
        $input = \Input::all();
        print_r($input);

        $validator = \Validator::make(
            array(
                'Flip Cards Title' => $input['form_flip']['form_flip_cards_title'],
                'Flip Cards Description' => $input['form_flip']['form_description'],
                'Flip Cards Footer' => $input['form_flip']['form_footer']
            ),
            array(
                'Flip Cards Title' => 'required',
                'Flip Cards Description' => 'required',
                'Flip Cards Footer' => 'required'
            )
        );

        if (!$validator->fails())
        {
            foreach ($input['flip_cards'] as $key => $value) {
                $validator_cards = \Validator::make(
                    array(
                        'Item Title' => $value['form_item_title'],
                        'Font Card' => $value['img_src1'],
                        'Back Card' => $value['img_src2']
                    ),
                    array(
                        'Item Title' => 'required',
                        'Font Card' => 'required',
                        'Back Card' => 'required'
                    )
                );
                if ($validator_cards->fails()) {
                    print_r($validator->messages());
                }

            }
        }
    }
}
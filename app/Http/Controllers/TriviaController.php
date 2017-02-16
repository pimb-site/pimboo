<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class TriviaController extends Controller
{

	public function validURL() {
		
		$url = \Input::get('video_url');
		
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$content = @file_get_contents('https://www.youtube.com/oembed?url='.$url.'&format=json');
			$array_information = json_decode($content, true);
			if(is_array($array_information)) {
				return \Response::json(['success' => true, 'thumbnail_url' => $array_information['thumbnail_url']]);
			}
		}
	
	}

    public function getNewForm($id) {
        if(\Auth::guest()) return view('auth/login');
        else return view('getNewFormTrivia', ['id' => $id]);
    }

    public function addTriviaQuiz()
    {
        if(\Auth::guest()) return view('auth/login');
        else return view('trivia_new');
    }

    public function viewTriviaQuiz()
    {
		$contentflip = \DB::select('select * from posts where type = "trivia"');
        return view('view_trivia_quiz', ['contentflip' => $contentflip]);
    }

    public function saveTriviaQuiz()
    {
		
		if(\Auth::guest()) return view('auth/login');

        $input = \Input::all();
        $validator = \Validator::make(
            array(
                'Trivia Title' => $input['form_flip']['form_flip_cards_title'],
                'Trivia Description' => $input['form_flip']['form_description'],
                'Trivia Footer' => $input['form_flip']['form_footer'],
                'Trivia Photo' => $input['form_flip']['form_photo'],
				'Trivia Facebook Photo' => $input['form_flip']['form_photo_facebook']
            ),
            array(
                'Trivia Title' => 'required',
                'Trivia Description' => 'required',
                'Trivia Footer' => 'required',
                'Trivia Photo' => 'required',
				'Trivia Facebook Photo' => 'required'
            )
        );
		

        if (!$validator->fails())
        {
            foreach ($input['flip_cards'] as $key => $value) {
                $validator_cards = \Validator::make(
                    array(
                        'Item Title' => $value['form_item_title'],
                        'Main photo' => $value['img_src1'],
						'Answer 1' => $value['answer1'],
						'Answer 2' => $value['answer2'],
						'Type your caption' => $value['caption']
                    ),
                    array(
                        'Item Title' => 'required',
                        'Main photo' => 'required',
						'Answer 1'   => 'required',
						'Answer 2'   => 'required',
						'Type your caption' => 'required'
                    )
                );

                if ($validator_cards->fails()) {
                    return \Response::json(['success' => false, 'errors' => $validator_cards->errors()]);
                }
            }

            if(!$validator_cards->fails()) {
                $errors_array = array();
                if(!file_exists('temp/'.$input['form_flip']['form_photo'])) $errors_array[] = 'Wrong photo link';
				if(!file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) $errors_array[] = 'Wrong Facebook photo link';
                foreach ($input['flip_cards'] as $key => $value) {
                    if(!file_exists('temp/'.$value['img_src1'])) $errors_array[] = 'Wrong front image link';
                    if(count($errors_array) > 0) return \Response::json(['success' => false, 'errors' => $errors_array]);
                }

                if(count($errors_array) == 0) {
                    $content = array();
                    $uniqid3 = uniqid();
					$uniqid4 = uniqid();
                    copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid3.'.jpeg');
					copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid4.'.jpeg');
                    unlink('temp/'.$input['form_flip']['form_photo']);
					unlink('temp/'.$input['form_flip']['form_photo_facebook']);
                    foreach ($input['flip_cards'] as $key => $value) {
                        $uniqid1 = uniqid();
                        $uniqid2 = uniqid();
                        copy('temp/'.$value['img_src1'], 'uploads/'.$uniqid1.'.jpeg');
                        unlink('temp/'.$value['img_src1']);
						$type1 = $type2 = $type3 = $type4 = 'false';
						if(isset($value['answer_check1'])) $type1 = 'true';
						if(isset($value['answer_check2'])) $type2 = 'true';
						
						
						if(!isset($value['answer3'])) $value['answer3'] = '';
						if(!isset($value['answer4'])) $value['answer4'] = '';
						if(isset($value['answer_check3'])) $type3 = 'true';
						if(isset($value['answer_check4'])) $type4 = 'true';
						
						
						$uniqid_img1 = $uniqid_img2 = $uniqid_img3 = $uniqid_img4 = '';
						
						if($value['type'] == 2) {
							if($value['answer_img1'] !='' && file_exists('temp/'.$value['answer_img1'])) {
								$uniqid_img1 = uniqid();
								copy('temp/'.$value['answer_img1'], 'uploads/'.$uniqid_img1.'.jpeg');
								unlink('temp/'.$value['answer_img1']);
								$uniqid_img1 = $uniqid_img1.".jpeg";
							} else $uniqid_img1 = '';
							
							if($value['answer_img2'] != '' && file_exists('temp/'.$value['answer_img2'])) {
								$uniqid_img2 = uniqid();
								copy('temp/'.$value['answer_img2'], 'uploads/'.$uniqid_img2.'.jpeg');
								unlink('temp/'.$value['answer_img2']);
								$uniqid_img2 = $uniqid_img2.".jpeg";
							} else $uniqid_img2 = '';
							
							if($value['answer_img3'] != '' && file_exists('temp/'.$value['answer_img3'])) {
								$uniqid_img3 = uniqid();
								copy('temp/'.$value['answer_img3'], 'uploads/'.$uniqid_img3.'.jpeg');
								unlink('temp/'.$value['answer_img3']);
								$uniqid_img3 = $uniqid_img3.".jpeg";
							} else $uniqid_img3 = '';
							
							if($value['answer_img4'] != '' && file_exists('temp/'.$value['answer_img4'])) {
								$uniqid_img4 = uniqid();
								copy('temp/'.$value['answer_img4'], 'uploads/'.$uniqid_img4.'.jpeg');
								unlink('temp/'.$value['answer_img4']);
								$uniqid_img4 = $uniqid_img4.".jpeg";
							} else $uniqid_img4 = '';
						}
						
                        $content[] = [
							'main_type'  => $value['type'],
                            'item_title' => $value['form_item_title'],
							'caption' => $value['caption'],
							'answer1' => $value['answer1'],
							'answer2' => $value['answer2'],
							'answer3' => $value['answer3'],
							'answer4' => $value['answer4'],
                            'front_card' => $uniqid1.".jpeg",
							'answer_check1' => $type1,
							'answer_check2' => $type2,
							'answer_check3' => $type3,
							'answer_check4' => $type4,
							'answer_img1' => $uniqid_img1,
							'answer_img2' => $uniqid_img2,
							'answer_img3' => $uniqid_img3,
							'answer_img4' => $uniqid_img4
                        ];
                    }
					$id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
						'type' => 'trivia']
					);
                    return \Response::json(['success' => true, 'id' => $id]);
                }
            }
        } else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
		
    }
}
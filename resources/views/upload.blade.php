@extends('app')
@section('content')
    {!! Form::open(['action' => 'ImageController@postUploadEnd', 'id' => 'form_upload_cards']) !!}
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add flip cards</div>

                    <div class="panel-body">
                        <div id="validation-alert"></div>
                        <div class="form_photo" style="display: none"></div>
                        <div class="form-group">
                            {!! Form::label('Flip Cards Title', 'Flip cards title:') !!}
                            {!! Form::text('form_flip[form_flip_cards_title]', null, ['class' => 'form-control', 'id' => 'form_flip_cards_title']) !!}
                            {!! Form::label('Description', 'Flip cards description:') !!}
                            {!! Form::textarea('form_flip[form_description]', null, ['class' => 'form-control', 'maxlength' => '150', 'id' => 'form_description', 'rows' => 3]) !!}
                            {!! Form::label('Footer', 'Flip Cards Footer:') !!}
                            {!! Form::textarea('form_flip[form_footer]', null, ['class' => 'form-control', 'maxlength' => '150', 'id' => 'form_footer']) !!}
                            {!! Form::label('Item Title', 'Item Title:') !!}
                            {!! Form::text('flip_cards[1][form_item_title]', null, ['class' => 'form-control']) !!}
                            {!! Form::hidden('form_flip[form_photo]', '', ['class' => 'form_set_photo ', 'autocomplete' => 'off']) !!}
                            {!! Form::hidden('flip_cards[1][img_src1]', '', ['class' => 'img_src1 form_1', 'autocomplete' => 'off']) !!}
                            {!! Form::hidden('flip_cards[1][img_src2]', '', ['class' => 'img_src2 form_1', 'autocomplete' => 'off']) !!}
                            {!! Form::button('Set Front Card', ['class' => 'btn btn-info form_front_card', 'id' => 'set_card_front_1', 'data-id' => '1']) !!}
                            {!! Form::button('Set Back Card', ['class' => 'btn btn-warning form_back_card', 'id' => 'set_card_back_1', 'data-id' => '1']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="wrap form_1" style="display:none" data-id="1">
                                <div class="front form_1" data-id="1"> </div>
                                <div class="back form_1" data-id="1"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::button('Set Photo', ['class' => 'btn btn-danger form_add_photo']) !!}
                {!! Form::button('Add New Card', ['class' => 'btn btn-danger form_add_card']) !!}
                {!! Form::button('Delete Card', ['class' => 'btn btn-danger form_delete_card']) !!}
                {!! Form::button('Save cards', ['class' => 'btn btn-danger form_save_cards']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
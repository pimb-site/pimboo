<div class="panel-body">
	<div class="form-group">
		{!! Form::label('Item Title', 'Item Title:') !!}
		{!! Form::text('flip_cards['.$id.'][form_item_title]', null, ['class' => 'form-control']) !!}
		{!! Form::hidden('flip_cards['.$id.'][img_src1]', '', ['class' => "img_src1 form_".$id, 'autocomplete' => 'off']) !!}
		{!! Form::hidden('flip_cards['.$id.'][img_src2]', '', ['class' => "img_src2 form_".$id, 'autocomplete' => 'off']) !!}
		{!! Form::button('Set Front Card', ['class' => 'btn btn-info form_front_card', 'id' => 'set_card_front_'.$id, 'data-id' => $id]) !!}
		{!! Form::button('Set Back Card', ['class' => 'btn btn-warning form_back_card', 'id' => 'set_card_back_'.$id, 'data-id' => $id]) !!}
	</div>
</div>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="wrap form_{!! $id !!}" style="display:none" data-id="{!! $id !!}">
            <div class="front form_{!! $id !!}" data-id="{!! $id !!}"> </div>
            <div class="back form_{!! $id !!}" data-id="{!! $id !!}"> </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$('#set_card_front_{{ $id }}').on('click', function(e) {
        current_id = $(this).data('id');
        check = 1;
        myPixie.open({
            url: e.target.src,
            image: e.target
        });
    });
    $('#set_card_back_{{ $id }}').on('click', function(e) {
        current_id = $(this).data('id');
        check = 2;
        myPixie.open({
            url: e.target.src,
            image: e.target
        });
    });
    $('.wrap.form_{!! $id !!}').click(function () {
        current_id = $(this).data('id');
        var wrap = $('.wrap.form_'+current_id);
        if($(wrap).css('-webkit-transform') == 'matrix(1, 0, 0, 1, 0, 0)') {
            $(wrap).css({'-webkit-transform':'rotateY(180deg)'});
        } else {
            $(wrap).css({'-webkit-transform':'rotateY(0deg)'});
        }
    });
</script>
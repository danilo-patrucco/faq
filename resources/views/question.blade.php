@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Question</div>

                    <div class="card-body">

                        {{$question->body}}
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary float-right"
                           href="{{ route('questions.edit',['id'=> $question->id])}}">
                            Edit Question
                        </a>

                        {{ Form::open(['method'  => 'DELETE', 'route' => ['questions.destroy', $question->id]])}}
                        <button class="btn btn-danger float-right mr-2" value="submit" type="submit" id="submit">Delete
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><a class="btn btn-primary float-left"
                                                href="{{ route('answers.create', ['question_id'=> $question->id])}}">
                            Answer Question
                        </a></div>

                    <div class="card-body">
                        @forelse($question->answers as $answer)
                            <div class="card">
                                <div class="card-body">{{$answer->body}}</div>
                                <div class="card-footer">
                                    <a class="btn btn-primary float-right"
                                       href="{{ route('answers.show', ['question_id'=> $question->id,'answer_id' => $answer->id]) }}">
                                        View
                                    </a>
                                        <button class="like-button" data-status="{{$answer->likes_count}}" data-id="{{ $answer->id }}">@if($answer->likes_count>0){{'Unlike'}}@else{{'Like'}}@endif</button>
                                </div>
                            </div>
                        @empty
                            <div class="card">

                                <div class="card-body"> No Answers</div>
                            </div>
                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>

        $(document).ready(function() {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

/* selector is like CSS selectors, it recalls the class automatically when it finds it in the code */
/*
* <div id="content"></div> --> $('#content')
* <input data-id="4" /> --> $('input[data-id="4"]')
*
* */
            $('.like-button').click(function () {

                var button = $(this);
                var status = parseInt(button.attr('data-status'));

                if(status==0) {
                    button.html('Unlike');
                    status = 1;
                }
                else{
                    button.html('Like');
                    status = 0;
                }

                $.ajax({
                   type: 'post',
                   url: 'toggleLike',
                   data: {answer_id:button.attr('data-id'), status:status},
                   success: function(data){
                       button.attr('data-status', status);
                   }
                });

            });

        });

    </script>
@endsection



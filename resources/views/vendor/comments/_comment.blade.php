@inject('markdown', 'Parsedown')
@php($markdown->setSafeMode(true))

@if(isset($reply) && $reply === true)
  <div id="comment-{{ $comment->id }}" class="media">
  {{-- TODO: Maxi, si los usuarios van a tener imagen comentar esta parte --}}
    <div class="mr-3" style="width: 60px;"></div>
@else
  <li id="comment-{{ $comment->id }}" class="media">
@endif
    {{-- <img class="mr-3" src="https://www.gravatar.com/avatar/{{ md5($comment->commenter->email ?? $comment->guest_email) }}.jpg?s=64" alt="{{ $comment->commenter->name ?? $comment->guest_name }} Avatar"> --}}
    <div class="media-body comment pl-0 pt-3 mb-0">
        {{-- <h5 class="mt-0 mb-1">{{ $comment->commenter->fullname ?? $comment->guest_name }} <small class="text-muted">- {{ $comment->created_at->diffForHumans() }}</small></h5> --}}
        {{-- <div style="white-space: pre-wrap;">{!! $markdown->line($comment->comment) !!}</div> --}}

        <div class="d-flex align-items-end">
            <p class="mb-0">{{ $comment->commenter->fullname ?? $comment->guest_name }}</p>
            <small class="ml-3"><span class="text-muted"> {{ $comment->created_at->isoFormat('LL, hh:mm a') }} </span></small>
        </div>
        <div class="mt-2 text-justify">
            {!! $markdown->line($comment->comment) !!}
        </div>

        <div>
            @can('reply-to-comment', $comment)
                <button data-toggle="modal" data-target="#reply-modal-{{ $comment->id }}" class="btn btn-sm btn-link text-uppercase">Responder</button>
            @endcan
            @can('edit-comment', $comment)
                <button data-toggle="modal" data-target="#comment-modal-{{ $comment->id }}" class="btn btn-sm btn-link text-uppercase">Editar</button>
            @endcan
            @can('delete-comment', $comment)
                <a href="{{ url('comments/' . $comment->id) }}" onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->id }}').submit();" class="btn btn-sm btn-link text-danger text-uppercase">Borrar</a>
                <form id="comment-delete-form-{{ $comment->id }}" action="{{ url('comments/' . $comment->id) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </div>

        @can('edit-comment', $comment)
            <div class="modal fade" id="comment-modal-{{ $comment->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ url('comments/' . $comment->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="modal-header bg-dark">
                                <h5 class="modal-title">Editar comentario</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body border-0 bg-dark">
                                <div class="form-group">
                                    <label for="message">Actualizar mensaje</label>
                                    <textarea required class="form-control form-control-square text-muted" name="message" rows="5">{{ $comment->comment }}</textarea>
                                    {{-- <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small> --}}
                                </div>
                            </div>
                            <div class="modal-footer bg-dark">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-white btn-square text-dark btn-sm text-uppercase">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can('reply-to-comment', $comment)
            <div class="modal fade" id="reply-modal-{{ $comment->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ url('comments/' . $comment->id) }}">
                            @csrf
                            <div class="modal-header bg-dark">
                                <h5 class="modal-title">Responder</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body border-0 bg-dark">
                                <div class="form-group">
                                    <label for="message">Ingrese su mensaje</label>
                                    <textarea required class="form-control form-control-square text-muted" name="message" rows="5"></textarea>
                                    {{-- <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small> --}}
                                </div>
                            </div>
                            <div class="modal-footer bg-dark">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-white btn-square text-dark btn-sm text-uppercase">Responder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        <br />{{-- Margin bottom --}}

        {{-- Recursion for children --}}
        @if($grouped_comments->has($comment->id))
            @foreach($grouped_comments[$comment->id] as $child)
                @include('comments::_comment', [
                    'comment' => $child,
                    'reply' => true,
                    'grouped_comments' => $grouped_comments
                ])
            @endforeach
        @endif

    </div>
@if(isset($reply) && $reply === true)
  </div>
@else
  </li>
@endif
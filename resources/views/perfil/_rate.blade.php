<div class="d-inline-block">
    <div class="rate float-left" @if( !($canQualify ?? false) ) qualified @endif>
        @for($star = 5; $star >=1; $star--)
            <span 
                @isset($stars) 
                    @if($stars == $star) checked @endif 
                @endif
                @if(($canQualify ?? false))
                    data-qualify
                    data-post-id="{{$post->id}}"
                    data-star="{{$star}}" 
                @endif
            >
            </span>
        @endfor
    </div>
</div>

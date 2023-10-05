{{--
  Title: Avia Section - Media Text
  Category: layout
  Mode: edit
  PostTypes: page post
  SupportsAnchor: true
--}}

<?php
$root = 'section-media-text';

$media_field    = get_field('media_type_field');
$is_image_media = $media_field === 'image';
$title          = get_field('title');
$text           = get_field('text');
$align          = get_field('align');
$media          = $is_image_media ? wp_get_attachment_image(get_field($media_field), 'full') : get_field($media_field);
$video          = get_field('video');
$video_button   = get_field('video_button');
$enable_button  = get_field('enable_button');
$button         = get_field('button');
$gift_modal     = get_field('button_modal');
$size           = get_field('size');
?>

<section class="{{ $root }} {{ $align ? $root.'--'.$align : '' }} {{ $size ? $root.'--'.$size : '' }}">
  <div class="container">

    @if ($media)
      <div class="{{ $root }}__media" data-aos="fade-{{ $align === 'right' ? 'left' : 'right' }}">
        @switch($media_field)
          @case('image')
            {!! $media !!}
            @break
          @case('video_media')
            <video autoplay loop muted playsinline width="100%" preload="none">
              <source src="{{ $media['url'] }}" type="{{ $media['mime_type'] }}" autostart="false">
            </video>
            @break
        @endswitch

        @if ($video)
          <button class="btn btn--primary" data-a11y-dialog-show="{{ $block['id'] }}">
            @svg('play')
            {{ $video_button }}
          </button>
        @endif
      </div>
    @endif

    <div class="{{ $root }}__content" data-aos="fade-{{ $align }}">
      @if ($title)
        <h3 class="{{ $root }}__title">
          {{ $title }}
        </h3>
      @endif

      @if ($text)
        <div class="{{ $root }}__text">
          {!! $text !!}

          @if ($enable_button && $button)
            <a href="{{ $button['url'] }}"
               class="btn btn--primary" {{ $gift_modal ? 'data-a11y-dialog-show=form-gift' : '' }}
               data-aos="fade-up"
               data-aos-delay="250"
            >
              @svg('airplane')
              {{ $button['title'] }}
            </a>
          @endif
        </div>
      @endif

    </div>
  </div>

  @if($video)
    <x-dialog id="{{ $block['id'] }}" :close="true" :title="false">
      {!! $video !!}
    </x-dialog>
  @endif
</section>

@php
  $dates = \App\Booking\Booking::available_dates();
@endphp

<form method="post" enctype="multipart/form-data" class="booking-order-form js-booking-order" data-dates="{{ json_encode($dates, JSON_FORCE_OBJECT) }}">
  <label class="inline-checkbox">
    <input type="checkbox" name="fixed_date" value="yes">
    <span>{{ __('Fixed date') }}</span>
  </label>

  <label data-show="fixed_date" class="radio-group radio-group--column">
    <span>{{ __('Select fixed date') }}</span>

    <select name="day">
      <option value="">{{ __('Select day', 'sage') }}</option>

      @foreach($dates as $day_ts => $slot_ts)
        <option value="{{ $day_ts }}">{{ wp_date('D j M', $day_ts) }}</option>
      @endforeach
    </select>

    <select name="date">
      <option value="">{{ __('Select time', 'sage') }}</option>
    </select>
  </label>

  <label>
    <span>{{ __('Name', 'sage') }}</span>
    <input type="text" name="name" placeholder="{{ __('Your name', 'sage') }}">
  </label>

  <label>
    <span>{{ __('Phone number', 'sage') }}</span>
    <input type="tel" name="phone" placeholder="+38 (096) 710-16-96">
  </label>

  <label>
    <span>{{ __('Email', 'sage') }}</span>
    <input type="email" name="email" placeholder="example@mail.com">
  </label>

  <div class="radio-group">
    @php
      $currency = get_field('order_currency', 'option');
      $price = '';
    @endphp
    <?php $type = get_field('simulator_type'); ?>
    <?php if (is_front_page()) { ?>
    @foreach (get_field('order_durations', 'option') as $item)
      <label>
        @if ($item['featured'])
            @php
              $price = $item['price'];
            @endphp
        @endif
        <input type="radio" name="duration" value="{{ $item['time'] }}" data-price="{{ $item['price'] }}" {{ checked($item['featured'] || $loop->first) }}>
        <span>{{ $item['time'] }} хв {{ $item['price'] }} {{ $currency['text'] }}</span>
      </label>
    @endforeach
    <?php } else { ?>
      @foreach (get_field('order_durations_2', 'option') as $item)
      <label>
        @if ($item['featured'])
            @php
              $price = $item['price'];
            @endphp
        @endif
        <input type="radio" name="duration" value="{{ $item['time'] }}" data-price="{{ $item['price'] }}" {{ checked($item['featured'] || $loop->first) }}>
        <span>{{ $item['time'] }} хв {{ $item['price'] }} {{ $currency['text'] }}</span>
      </label>
    @endforeach
    <?php } ?>
  </div>

  <input type="hidden" name="gift" value="yes">

  <label>
    <span>{{ __('Promocode', 'sage') }}</span>
    <input type="text" name="promocode" placeholder="AVIA-SIM">
  </label>

  <label>
    <span>{{ __('Comment', 'sage') }}</span>
    <textarea name="comment"></textarea>
  </label>

  <label class="inline-checkbox">
    <input type="checkbox" name="delivery_gift" value="yes">
    <span>{{ __('Доставити пластикову карту') }}</span>
  </label>

  <label data-show="delivery_gift">
    <span>{{ __('Delivery Address', 'sage') }}</span>
    <input type="text" name="address" placeholder="м. Київ Нова Пошта Відділення №1">
  </label>

  @include('partials.checkbox-rules')

  <div class="button-group">
    <button type="submit" class="btn btn--primary">
      @svg('images/card.svg') {{ __('Pay', 'sage') }} <span>{{ $price }}</span> {{ $currency['text'] }}
    </button>
  </div>

  <div class="form-message"></div>

  <?php $type = get_field('simulator_type'); ?>
  <div style="display: none;"><input type="text" name="_text" value=""></div>
{{--  <input type="hidden" name="date">--}}
  <input type="hidden" name="bookingtype" value="<?php if ( is_front_page() ) : ?>Boeing<?php else : ?>F18<?php endif; ?>">
  <input type="hidden" name="price" value="{{ $price }}">
</form>

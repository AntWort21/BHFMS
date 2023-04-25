<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <link href="{{ asset('/css/vue-multiselect.css') }}" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2jQ6h9LFcb7VMwDAiCAyCRKez0ucwwwI&libraries=places&callback=Function.prototype"></script>

    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>

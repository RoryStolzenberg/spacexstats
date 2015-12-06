<div class="object-actions container">
    <span class="gr-4">
        <i class="fa fa-eye fa-2x"></i> {{ $object->views }} Views
    </span>
    <span class="gr-4">
        <i class="fa fa-star fa-2x" ng-click="toggleFavorite()" ng-class="{ 'is-favorited' : isFavorited === true }"></i>
        <span>@{{ favoritesText }}</span>
    </span>
    <span class="gr-4">
        @if ($object->hasFile())
            <a href="{{ $object->media }}" target="_blank" download><i class="fa fa-download fa-2x" ng-click="incrementDownloads()"></i></a> {{ $object->downloads()->count() }} Downloads
        @else
            <a href="/missioncontrol/objects/{{ $object->object_id }}/download" target="_blank" download><i class="fa fa-download fa-2x"></i></a> {{ $object->downloads()->count() }} Downloads
        @endif
    </span>
</div>
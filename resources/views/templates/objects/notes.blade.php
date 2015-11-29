<h3>Your Note</h3>
@if (Auth::isSubscriber())
    <form name="noteForm" novalidate>
        <div ng-show="noteState === 'read'">
            <p ng-bind-html="noteReadText"></p>
            <button ng-click="changeNoteState()">@{{ noteButtonText }}</button>
        </div>

        <div ng-show="noteState === 'write'">
            <textarea ng-model="note" required></textarea>
            <button ng-click="saveNote()" ng-disabled="noteForm.$invalid">Save Note</button>
            <button class="warning" ng-if="originalNote !== ''" ng-click="deleteNote()">Delete Note</button>
        </div>
    </form>
@else
    <p>Sign up for <a href="/missioncontrol">Mission Control</a> to leave personal notes about this.</p>
@endif
<h3>Your Note</h3>
@if (Auth::isSubscriber())
    <form>
        <div ng-show="noteState === 'read'">
            <p ng-bind-html="noteReadText"></p>
            <button ng-click="changeNoteState()">@{{ noteButtonText }}</button>
        </div>

        <div ng-show="noteState === 'write'">
            <textarea ng-model="note"></textarea>
            <button ng-click="saveNote()" ng-disable="note().length == 0">Save Note</button>
            <button class="delete" ng-if="originalNote !== ''" ng-click="deleteNote()">Delete Note</button>
        </div>
    </form>
@else
    <p>Sign up for <a href="/missioncontrol">Mission Control</a> to leave personal notes about this.</p>
@endif
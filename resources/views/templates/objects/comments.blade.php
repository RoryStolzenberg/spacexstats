<h2>{{ $object->comments->count() }} Comments</h2>
<section class="comments" ng-controller="commentsController" ng-strict-di>
    @if (Auth::isSubscriber())
        <form name="commentForm">
            <textarea ng-model="newComment" minlength="10" required placeholder="You can use markdown here."></textarea>
            <input type="submit" ng-click="addTopLevelComment(commentForm)" ng-disabled="commentForm.$invalid" value="Add comment" />
        </form>
        <p ng-if="!commentsAreLoaded">Comments are loading...</p>
        <div ui-tree data-nodrop-enabled="true" data-drag-enabled="false">
            <ul ui-tree-nodes="" ng-model="comments">
                <li ng-repeat="comment in comments" class="@{{ 'comment-depth-' + comment.depth }}" ui-tree-node ng-include="'nodes_renderer.html'"></li>
            </ul>
        </div>
    @else
        <p>You need to be a Mission Control subscriber to comment. Sign up today!</p>
    @endif
</section>

<!-- Nested node template -->
<script type="text/ng-template" id="nodes_renderer.html">
    <div ui-tree-handle>

        <span class="comment-owner">
            <a href="@{{ '/users/' + comment.user.username }}">@{{ comment.user.username }}</a>
        </span>

        <p class="comment-body">@{{ comment.comment }}</p>

        <ul class="comment-actions">
            <li ng-click="comment.toggleReplyState()">Reply</li>
            <li ng-click="comment.toggleEditState()">Edit</li>
            <li ng-click="comment.toggleDeleteState()" ng-if="comment.ownership == true">Delete</li>
        </ul>

        <div ng-if="comment.isReplying === true" ng-form="commentReplyForm">
            <textarea ng-model="comment.replyText" minlength="10" required placeholder="You can use markdown here."></textarea>

            <button type="submit" ng-click="comment.reply()" ng-disabled="commentReplyForm.$invalid">Reply</button>
            <button type="reset" ng-click="comment.toggleReplyState()">Cancel</button>
        </div>

        <div ng-if="comment.isEditing === true" ng-form="commentEditForm">
            <textarea ng-model="comment.editText" minlength="10" required placeholder="You can use markdown here."></textarea>

            <button type="submit" ng-click="comment.edit()" ng-disabled="commentEditForm.$invalid">Edit</button>
            <button type="reset" ng-click="comment.toggleEditState()">Cancel</button>
        </div>

        <div ng-if="comment.isDeleting === true">
            <button type="submit" ng-click="comment.delete(this)">Delete</button>
            <button type="reset" ng-click="comment.toggleDeleteState()">Cancel</button>
        </div>

    </div>
    <ul ui-tree-nodes="" ng-model="comment.children">
        <li ng-repeat="comment in comment.children" class="@{{ 'comment-depth-' + comment.depth }}" ui-tree-node ng-include="'nodes_renderer.html'"></li>
    </ul>
</script>
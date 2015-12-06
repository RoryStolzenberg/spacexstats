<h2>{{ $object->comments->count() }} Comments</h2>
<section id="comments" class="comments scrollto" ng-controller="commentsController" ng-strict-di>
    @if (Auth::isSubscriber())
        <form name="commentForm">
            <textarea class="half" ng-model="newComment" minlength="10" required placeholder="You can use markdown here."></textarea>
            <input type="submit" ng-click="addTopLevelComment(commentForm)" ng-disabled="commentForm.$invalid || isAddingTopLevelComment" value="Add comment" />
        </form>
        <p class="exclaim" ng-if="!commentsAreLoaded">Comments are loading...</p>
        <div ui-tree data-nodrop-enabled="true" data-drag-enabled="false">
            <ul ui-tree-nodes="" ng-model="comments">
                <li ng-repeat="comment in comments" class="@{{ 'comment-depth-' + comment.depth }}" ui-tree-node ng-include="'nodes_renderer.html'"></li>
            </ul>
        </div>
    @else
        <p class="exclaim">You need to be a Mission Control subscriber to comment. <a href="/missioncontrol">Sign up today!</a></p>
    @endif
</section>

<!-- Nested node template -->
<script type="text/ng-template" id="nodes_renderer.html">
    <div ui-tree-handle>

        <span class="comment-owner">
            <a href="@{{ '/users/' + comment.username }}">@{{ comment.username }}</a>
            <span class="deleted" ng-if="comment.username == null">Deleted</span>
            <span class="created-at lowvisibility opacity" ng-if="comment.username !== null">@{{ comment.created_at_relative }}</span>
        </span>

        <p class="comment-body comment md" ng-bind-html="comment.comment_md"></p>

        <ul class="comment-actions">
            <li ng-click="comment.toggleReplyState()" ng-if="comment.deleted_at == null">Reply</li>
            <li ng-click="comment.toggleEditState()" ng-if="comment.ownership == true && comment.deleted_at == null">Edit</li>
            <li ng-click="comment.toggleDeleteState()" ng-if="comment.ownership == true && comment.deleted_at == null">Delete</li>
        </ul>

        <form ng-if="comment.isReplying === true" name="commentReplyForm">
            <textarea class="half" ng-model="comment.replyText" minlength="10" required placeholder="You can use markdown here."></textarea>

            <button type="submit" ng-click="comment.reply()" ng-disabled="commentReplyForm.$invalid || comment.isSending.reply">Reply</button>
            <button type="reset" ng-click="comment.toggleReplyState()" ng-disabled="comment.isSendingReply">Cancel</button>
        </form>

        <form ng-if="comment.isEditing === true" name="commentEditForm">
            <textarea class="half" ng-model="comment.editText" minlength="10" required placeholder="You can use markdown here."></textarea>

            <button type="submit" ng-click="comment.edit()" ng-disabled="commentEditForm.$invalid || comment.isSending.edit">Edit</button>
            <button type="reset" ng-click="comment.toggleEditState()" ng-disabled="comment.isSendingEdit">Cancel</button>
        </form>

        <form ng-if="comment.isDeleting === true">
            <button type="submit" class="warning" ng-click="comment.delete(this)" ng-disabled="comment.isSending.deletion">Delete</button>
            <button type="reset" ng-click="comment.toggleDeleteState()" ng-disabled="comment.isSending.deletion">Cancel</button>
        </form>

    </div>
    <ul ui-tree-nodes="" ng-model="comment.children">
        <li ng-repeat="comment in comment.children" class="@{{ 'comment-depth-' + comment.depth }}" ui-tree-node ng-include="'nodes_renderer.html'"></li>
    </ul>
</script>
@extends('templates.main')

@section('scripts')
    {{ HTML::script('ReviewViewModel.js') }ReviewViewModel.js="text/javascript">
        $(document).ready(function() {
            ko.applyBindings(new reviewViewModel());
        });
    </script>
    <script type="text/html" id="object-review-template">
        <tr>
            <td data-bind="text: name"></td>
            <td data-bind="text: type"></td>
            <td>
                <button data-bind="click: $root.action.bind($data, object_id, 'approve')">Approve</button>
                <button data-bind="click: $root.action.bind($data, object_id, 'remove')">Remove</button>
            </td>
        </tr>
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Review Queue</h1>
        <main>
            <table data-bind="template: { name: 'object-review-template', foreach: objects, as: 'object' }">
            </table>
        </main>
    </div>
@stop
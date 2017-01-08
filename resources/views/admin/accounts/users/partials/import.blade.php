<div class="modal fade" id="importUsers" tabindex="-1" role="dialog" aria-labelledby="importUsersLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if(isset($title))
                {!! Form::open(['route' => ['admin.users.process.import', ['type' => $title]], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
            @else                
                {!! Form::open(['route' => ['admin.users.process.import'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
            @endif
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="importUsersLabel">Import Users</h4>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="{{ getColumns(12) }}">
                                <div class="form-group @if ($errors->has('file')) has-error has-feedback @endif">
                                    <label class="control-label" for="avatar">Upload File</label><br/>
                                    {!! Form::file('file') !!}
                                    <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                    <span id="inputError2Status" class="sr-only">(error)</span>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Import', ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div id="userForm" v-el="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ fields.user_id ? 'Edit' : 'Add' }} user</h4>
            </div>
            <div class="modal-body">
                <errors errors="@{{ errors }}"></errors>


                <form v-on="submit: onSubmitForm" role="form">
                    <input v-model="fields._token" type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div v-show="!fields.user_id" class="form-group">
                        <label for="name">Email:</label>
                        <input v-model="fields.email" type="text" class="form-control" id="email">
                    </div>

                    <div id="changePassword">
                        <div class="form-group">
                            <label for="phone">Password</label>
                            <input v-model="fields.password" type="password" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <label for="phone">Password confirmation</label>
                            <input v-model="fields.password_confirmation" type="password" class="form-control"
                                   id="password_confirmation">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
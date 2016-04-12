<div id="parentForm" v-el="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ fields.user_id ? 'Edit' : 'Add' }} parent</h4>
            </div>
             <form v-on="submit: onSubmitForm" role="form">
            <div class="modal-body">
                <errors errors="@{{ errors  }}"></errors>

                    <input v-model="fields._token" type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="form-group">
                        <label for="name">Parent name:</label>
                        <input v-model="fields.name" type="text" class="form-control" id="name">
                    </div>
                     <div v-show="!fields.user_id" class="form-group">
                                            <label for="name">Parent email:</label>
                                            <input v-model="fields.email" type="text" class="form-control" id="email">
                     </div>
                    <div class="form-group">
                        <label for="phone">Phone number: </label>
                        <input v-model="fields.phone" type="text" class="form-control" id="phone">
                    </div>
                    <div class="form-group" v-show="!passwordChange">
                        <input type="checkbox" v-model="passwordChange"> Change password
                    </div>

                    <div id="changePassword" v-show="passwordChange">
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
            </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>

                </form>
        </div>

    </div>
</div>
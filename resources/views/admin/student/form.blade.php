<div id="studentForm" v-el="modal" class="modal fade" role="dialog"
     v-on="hide.bs.modal: resetFields">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ student_id ? 'Edit' : 'Add' }} student</h4>
            </div>
             <form v-on="submit: onSubmitForm" role="form">
            <div class="modal-body">
                <errors errors="@{{ errors }}"></errors>


                    <input v-model="fields._token" type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Student name:</label>
                        <input v-model="fields.name" type="text" class="form-control" id="name">
                    </div>
                    <selectize id="selectize-parent"
                            label="Select parent"
                            placeholder="Pick a parent, start typing.."
                            url="{{ route('admin::parent.search', null) }}"
                            value-field="user_id"
                            search-field="name"
                            value="@{{@ fields.user_id }}">
                    </selectize>

                    <selectize id="selectize-teacher"
                               label="Select teacher"
                               placeholder="Pick a teacher, start typing.."
                               url="{{ route('teacher.search', null) }}"
                               value-field="teacher_id"
                               search-field="name"
                               value="@{{@ fields.teacher_id }}">
                    </selectize>
             </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
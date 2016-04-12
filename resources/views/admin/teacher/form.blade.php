<div id="teacherForm" v-el="modal" class="modal fade" role="dialog"v-on="hide.bs.modal: resetFields">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ teacher_id ? 'Edit' : 'Add' }} Teacher</h4>
            </div>
            <form v-on="submit: onSubmitForm" role="form">
            <div class="modal-body">
                <errors errors="@{{ errors }}"></errors>
                <form v-on="submit: onSubmitForm" role="form">
                    <input v-model="fields._token" type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Teacher Name:</label>
                        <input v-model="fields.name" type="text" class="form-control" id="name">
                    </div>

                    <selectize id="selectize-teacher"
                               label="Select School"
                               placeholder="Pick a school, start typing.."
                               url="{{ route('admin::school.search', null) }}"
                               value-field="school_id"
                               search-field="name"
                               value="@{{@ fields.school_id }}">
                    </selectize>

                    <div class="form-group">
                        <label for="name">Room:</label>
                         <input v-model="fields.room" type="text" class="form-control" id="room">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
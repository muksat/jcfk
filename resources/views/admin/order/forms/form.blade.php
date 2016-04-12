<div id="parentForm" v-el="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ fields.order_form_id ? 'Edit' : 'Add' }} order form</h4>
            </div>
            <div class="modal-body">
                <errors errors="@{{ errors  }}"></errors>
                <form v-on="submit: onSubmitForm" role="form">
                    <input v-model="fields._token" type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="start_date">Start date:</label>
                        <input id="start_date"
                               v-date="fields.start_date"
                               v-model="fields.start_date"
                               placeholder="MM-DD-YYYY"
                               class="form-control"
                               name="start_date" type="text">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End date:</label>
                        <input id="end_date"
                               v-date="fields.end_date"
                               v-model="fields.end_date"
                               placeholder="MM-DD-YYYY"
                               class="form-control"
                               name="end_date" type="text">
                    </div>
                    <selectize id="selectize-school"
                               label="Select school"
                               placeholder="Pick a school, start typing.."
                               url="{{ route('admin::school.search', null) }}"
                               value-field="school_id"
                               search-field="name"
                               value="@{{@ fields.school_id }}">
                        </selectize>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
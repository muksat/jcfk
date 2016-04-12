<div id="mealForm" v-el="modal" class="modal fade" role="dialog"
     v-on="hide.bs.modal: resetFields">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ meal_id ? 'Edit' : 'Add' }} meal</h4>
            </div>
             <form v-on="submit: onSubmitForm" role="form">
            <div class="modal-body">


                    <input v-model="fields._token" type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name">Meal:</label>
                        <input v-model="fields.meal_name" type="text" class="form-control" id="meal_name">
                    </div>

                    <div class="form-group">
                        <label for="name">Description:</label>
                        <textarea v-model="fields.description" type="text" class="form-control" id="description"></textarea>
                    </div>
             </div>
                    <div class="modal-footer">
                         <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                 </form>
        </div>
    </div>
</div>
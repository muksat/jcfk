<div id="schoolForm" v-el="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ school_id ? 'Edit' : 'Add' }} school</h4>
            </div>
            <form v-on="submit: onSubmitForm" role="form">
            <div class="modal-body">

                    <input v-model="fields._token" type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name">School Name:</label>
                        <input v-model="fields.name" type="text" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Meal Price</label>
                        <input v-model="fields.meal_price" type="text" class="form-control" id="meal_price" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number: </label>
                        <input v-model="fields.phone" type="text" class="form-control" id="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address: </label>
                        <input v-model="fields.address" type="text" class="form-control" id="address" required>
                    </div>

                    {{--<div class="form-group">--}}
                              {{--<label for="address">Province</label>--}}
                              {{--<input v-model="fields.region" type="text" class="form-control" id="address" value="ON"  readonly>--}}
                     {{--</div>--}}

                   <div class="form-group">
                   <geoform city-id="@{{@ fields.city_id }}" region="@{{@ fields.region }}"></geoform>
                   </div>

                    <div class="form-group">
                        <label for="postalcode">Postal code: </label>
                        <input v-model="fields.postalcode" type="text" class="form-control" id="postalcode" required>
                    </div>
            </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Submit</button>
                    </div>
             </form>
        </div>

    </div>
</div>
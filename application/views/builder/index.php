<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>List </h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <form id="form" data-parsley-validate="" class="form-horizontal col-md-12 form-label-left" novalidate="" method="post" action="<?= site_url() ?>/P_master_mappingCoa/save">
                    <div id='outer-form'>
                        <div class="col-sm-12">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jumlah Row
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input id="input-add-row" type="number" class="form-control col-md-12 text-right" name='jumlah_row' value=1 disabled>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <button id="btn-add-row" class="btn btn-success col-md-12" type="button">Add Row</button>
                                </div>
                            </div>
                        </div>
                        <div class="e-row col-md-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Row - 1</h2>
                                    <button id="btn-remove-row" class="btn btn-danger col-md-1 float-right" type="button">Delete</button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content outer-column">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jumlah Column
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input class="form-control col-md-12 text-right input-add-column" type="number" value=1 name="jumlah_column[]" disabled>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <button class="btn-add-column btn btn-success col-md-12" type="button">Add Column</button>
                                        </div>
                                    </div>
                                    <div class="e-column col-md-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Column - 1</h2>
                                                <button class="btn-remove-column btn btn-danger col-md-1 float-right" type="button">Delete</button>

                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content outer-item">

                                                <div class="col-md-12">
                                                    <table class="table table-striped table-dark">
                                                        <thead>
                                                            <tr>
                                                                <th>label</th>
                                                                <th>tag</th>
                                                                <th>tipe</th>
                                                                <th>id</th>
                                                                <th>class</th>
                                                                <th>name</th>
                                                                <th>value</th>
                                                                <th>attribut</th>
                                                                <th>delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tbody-item">
                                                            <tr class="tr-item">
                                                                <td>
                                                                    <input class="input-item form-control" type="text" name="item[0][0][0][label]" sub="label">
                                                                </td>
                                                                <td>
                                                                    <select class="input-item custom-select" name="item[0][0][0][tag]" sub="tag">
                                                                        <option value="input">input</option>
                                                                        <option value="select">select</option>
                                                                        <option value="textarea">textarea</option>
                                                                        <option value="table" disabled>table soon</option>
                                                                        <option value="button">button</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="input-item custom-select" name="item[0][0][0][tipe]" sub="tipe">
                                                                        <option value="number">number</option>
                                                                        <option value="text">text</option>
                                                                        <option value="checkbox">checkbox</option>
                                                                        <option value="date">date</option>
                                                                        <option value="email">email</option>
                                                                        <option value="password">password</option>
                                                                        <option value="file">file</option>
                                                                        <option value="button">button</option>
                                                                        <option value="submit">submit</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="input-item form-control" type="text" name="item[0][0][0][id]" sub="id">
                                                                </td>
                                                                <td>
                                                                    <input class="input-item form-control" type="text" name="item[0][0][0][class]" sub="class">
                                                                </td>
                                                                <td>
                                                                    <input class="input-item form-control" type="text" name="item[0][0][0][name]" sub="name">
                                                                </td>
                                                                <td>
                                                                    <input class="input-item form-control" type="text" name="item[0][0][0][value]" sub="value">
                                                                </td>
                                                                <td>
                                                                    <input class="input-item form-control" type="text" name="item[0][0][0][attribut]" sub="attribut">
                                                                </td>
                                                                <td>
                                                                    <button class="btn-remove-input-item btn btn-danger col-md-12" type="button">Delete</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-success col-md-2 offset-md-10 btn-add-item" type="button">Add Item</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="ln_solid"></div>

                        <div class="item form-group">
                            <div class="center-margin">
                                <button type="submit" class="btn btn-success">Build</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
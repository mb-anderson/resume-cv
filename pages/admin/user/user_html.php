<?php $user = $this->user;?>
<div class="container mt-5">
    <div class="row">
        <?php $this->printMessages(); ?>
        <form class="container-fluid row text-center" method="POST">
            <input type="text" class="d-none" name="form_build_id" value="<?php echo $this->form_build_id; ?>"/>
            <div class="col-sm-6">
                <div class="row text-left">
                    <div class="col-sm-12 text-left">
                        <h4><?php echo _t(33); ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo _t(20); ?></label>
                        <input class="form-control" <?php echo $this->operation === "update" ? "disabled" : ""; ?> type="text" name="user_info[USERNAME]" value="<?php echo $user->USERNAME; ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo _t(27); ?></label>
                        <input class="form-control" type="text" name="user_info[NAME]" value="<?php echo $user->NAME; ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo mb_convert_case(_t(28), MB_CASE_TITLE); ?></label>
                        <input class="form-control" type="text" name="user_info[SURNAME]" value="<?php echo $user->SURNAME; ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo _t(35); ?></label>
                        <input class="form-control" type="text" name="user_info[EMAIL]" value="<?php echo $user->EMAIL; ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo mb_convert_case(_t(29), MB_CASE_TITLE); ?></label>
                        <input class="form-control" type="text" name="user_info[PHONE]" placeholder="5xxxxxxxxx" value="<?php echo $user->PHONE; ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo _t(36); ?></label>
                        <select class="selectpicker form-control" multiple name="user_info[ROLES][]">
                            <?php foreach ($this->current_user_roles as $role){ ?>
                            <option selected><?php echo $role; ?></option>
                            <?php } ?>
                            <?php foreach ($this->excluded_roles as $role){ ?>
                            <option><?php echo $role; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <input type="submit" name="save" class="btn btn-success form-control" value="<?php echo $this->operation == "update" ? _t(37) : _t(14); ?>"/> 
                    </div>
                </div>
        </div>
        <?php if($this->operation == "update"){ ?>
        <div class="col-sm-6">
                <div class="row text-left">
                    <div class="col-sm-12 text-left">
                        <h4><?php echo _t(38); ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo _t(39); ?></label>
                        <input class="form-control" type="password" name="password[ORIGINAL_PASSWORD]" autocomplete="false"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo _t(22); ?></label>
                        <input class="form-control" type="password" name="password[PASSWORD]" autocomplete="new-password"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-left">
                        <label><?php echo _t(40); ?></label>
                        <input class="form-control" type="password" name="password[PASSWORD2]" autocomplete="new-password"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="submit" name="change_password" class="btn btn-success form-control" value="<?php echo _t(38); ?>"/> 
                    </div>
                </div>
            </div>
        </form>
        <?php } ?>
    </div>
</div>
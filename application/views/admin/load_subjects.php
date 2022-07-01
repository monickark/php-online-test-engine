<?php
if(!empty($subject)) { 
foreach($subject as $val) { ?>
<option value="">Select Subject</option>
<option value="<?php echo $val['sub_id'];?>"><?php echo $val['subject']; ?></option>
<?php } } else { ?>
<option value="">No Subject Found</option>
<?php } ?>
<?php
if(!empty($passage)) { 
foreach($passage as $val) { ?>
<option value="">Select Passage</option>
<option value="<?php echo $val['pid'];?>"><?php echo $val['passage_title']; ?></option>
<?php } } else { ?>
<option value="">No Passage Found</option>
<?php } ?>
<script language="javascript">
    function displ()
    {
        if (document.userform.selectrolename.options[0].value === true) {
            return false;
        }
        else {
    <?php foreach (buildroleslist() as $build) { ?>
            if (document.userform.selectrolename.options[document.userform.selectrolename.selectedIndex].value === '<?= $build->id; ?>') {    
                //if
                if(document.userform.selectrolename.options[document.userform.selectrolename.selectedIndex].value==='5'){
                    document.userform.candidateid.value = 'A' + '<?= generatecadidateid2('AE'); ?>';                     
                }else if(document.userform.selectrolename.options[document.userform.selectrolename.selectedIndex].value==='6'){
                    document.userform.candidateid.value = 'E' + '<?= generatecadidateid2('AE'); ?>';               
                }else if(document.userform.selectrolename.options[document.userform.selectrolename.selectedIndex].value==='10'){
                    document.userform.candidateid.value = 'D' + '<?= generatecadidateid2('AE'); ?>';
                }else if(document.userform.selectrolename.options[document.userform.selectrolename.selectedIndex].value==='12'){
                    document.userform.candidateid.value = 'C' + '<?= generatecadidateid2('AE'); ?>';
                }else if(document.userform.selectrolename.options[document.userform.selectrolename.selectedIndex].value==='13'){
                    document.userform.candidateid.value = 'B' + '<?= generatecadidateid2('AE'); ?>';
                }else if(document.userform.selectrolename.options[document.userform.selectrolename.selectedIndex].value==='16'){
                    document.userform.candidateid.value = 'A' + '<?= generatecadidateid2('AE'); ?>';
                }
            }
    <?php } ?>
        }       
    }
</script>


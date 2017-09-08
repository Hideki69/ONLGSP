<?php

// fonction hostname
function cmdJeux($nom, $cmd)
{
    if($nom == 'insurgency' && $cmd == 'update'){
        return 'sh /home/ONLGSP/insurgency_update.sh';
    }

    if($nom == 'kf' && $cmd == 'update'){
        return 'sh /home/ONLGSP/kf_update.sh';
    }

    if($nom == 'kf2' && $cmd == 'update'){
        return 'sh /home/ONLGSP/kf2_update.sh';
    }
    
        if($nom == 'insurgency' && $cmd == 'start'){
        return 'sh /home/ONLGSP/insurgency_start.sh';
    }

    if($nom == 'kf' && $cmd == 'start'){
        return 'sh /home/ONLGSP/kf_start.sh';
    }

    if($nom == 'kf2' && $cmd == 'start'){
        return 'sh /home/ONLGSP/kf2_start.sh';
    }
    
        if($nom == 'insurgency' && $cmd == 'stop'){
        return 'sh /home/ONLGSP/insurgency_stop.sh';
    }

    if($nom == 'kf' && $cmd == 'stop'){
        return 'sh /home/ONLGSP/kf_stop.sh';
    }

    if($nom == 'kf2' && $cmd == 'stop'){
        return 'sh /home/ONLGSP/kf2_stop.sh';
    }
    
        if($nom == 'insurgency' && $cmd == 'reboot'){
        return 'sh /home/ONLGSP/insurgency_reboot.sh';
    }

    if($nom == 'kf' && $cmd == 'reboot'){
        return 'sh /home/ONLGSP/kf_reboot.sh';
    }

    if($nom == 'kf2' && $cmd == 'reboot'){
        return 'sh /home/ONLGSP/kf2_reboot.sh';
    }
    
        if($nom == 'insurgency' && $cmd == 'delete'){
        return 'sh /home/ONLGSP/insurgency_delete.sh';
    }

    if($nom == 'kf' && $cmd == 'delete'){
        return 'sh /home/ONLGSP/kf_delete.sh';
    }

    if($nom == 'kf2' && $cmd == 'delete'){
        return 'sh /home/ONLGSP/kf2_delete.sh';
    }

}

?>
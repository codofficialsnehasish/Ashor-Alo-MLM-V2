<?php 
    use Illuminate\Support\Str;
    use App\Models\Products;
    use App\Models\Carts;
    use Carbon\Carbon;
    use App\Models\Orders;
    use App\Models\User;
    use App\Models\OrderProducts;
    use App\Models\TopUp;
    use App\Models\Kyc;
    use App\Models\BinaryTree;


    if (!function_exists('get_user_details')){
        function get_user_details($id){
            $user = User::find($id);
            if($user){
                return $user;
            }else{
                return '';
            }
        }
    }


    if (!function_exists('get_name')){
        function get_name($id){
            $user = User::find($id);
            if($user){
                return $user->name;
            }else{
                return '';
            }
        }
    }

    if (!function_exists('get_name_by_user_id')){
        function get_name_by_user_id($user_id){
            $user = User::where('user_id',$user_id)->first();
            if($user){
                return $user->name;
            }else{
                return '';
            }
        }
    }

    if (!function_exists('get_user_id')){
        function get_user_id($id){
            $user = User::find($id);
            if($user){
                return $user->user_id;
            }else{
                return '';
            }
        }
    }

    if (!function_exists('get_id_using_user_id')){
        function get_id_using_user_id($user_id){
            $user = User::where('user_id',$user_id)->first();
            if($user){
                return $user->id;
            }else{
                return '';
            }
        }
    }
    
    if(!function_exists('is_kyc_exists')) {
        function is_kyc_exists($kyc){
            if(!empty($kyc)){
                return true;
            }else{
                return false;
            }
        }
    }

    if(!function_exists('check_kyc_status')){
        function check_kyc_status($user_id){
            $kyc = DB::table('kycs')->where('user_id',$user_id)->first();
            if($kyc){
                if($kyc->is_confirmed == 0){
                    $str = '<span class="badge badge-pill badge-warning ml-3">Pending</span>';
                }elseif($kyc->is_confirmed == 1){
                    $str = '<span class="badge badge-pill badge-success ml-3">Completed</span>';
                }else{
                    $str = '<span class="badge badge-pill badge-danger ml-3">Cancelled</span>';
                }
            }else{
                $str = '<span class="badge badge-pill badge-warning ml-3">Pending</span>';
            }
            return $str;
        }
    }

    if(!function_exists('check_kyc_status_for_menu')){
        function check_kyc_status_for_menu($user_id){
            $kyc = DB::table('kycs')->where('user_id',$user_id)->first();
            if($kyc){
                if($kyc->is_confirmed == 0){
                    $str = '<span class="badge badge-pill badge-warning ml-3"><i class="fas fas fa-clock"></i></span>';
                }elseif($kyc->is_confirmed == 1){
                    $str = '<span class="badge badge-pill badge-success ml-3"><i class="fas fa-check-circle"></i></span>';
                }else{
                    $str = '<span class="badge badge-pill badge-danger ml-3"><i class="fas fa-times-circle"></i></span>';
                }
            }else{
                $str = '<span class="badge badge-pill badge-warning ml-3"><i class="fas fas fa-clock"></i></span>';
            }
            return $str;
        }
    }

    if(!function_exists('check_kyc_submit_button')){
        function check_kyc_submit_button($user_id){
            $kyc = DB::table('kycs')->where('user_id',$user_id)->first();
            if($kyc){
                if($kyc->is_confirmed == 0 || $kyc->is_confirmed == 1){
                    return 'disabled';
                }else{
                    return '';
                }
            }
        }
    }

    if(!function_exists('check_identy_proof_status')){
        function check_identy_proof_status($kyc){
            if(is_kyc_exists($kyc)){
                if($kyc->identy_proof_status == 0){
                    $str = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Pending"><i class="fas fas fa-clock"></i></span>';
                }elseif($kyc->identy_proof_status == 1){
                    $str = '<span class="text-success" data-toggle="tooltip" data-placement="top" title="Verified"><i class="fas fa-check-circle"></i></span>';
                }else{
                    $str = '<span class="text-danger" data-toggle="popover" data-content="' . htmlspecialchars($kyc->identy_proof_remarks, ENT_QUOTES, 'UTF-8') . '" title="Cancelled"><i class="fas fa-times-circle"></i> ' . htmlspecialchars($kyc->identy_proof_remarks, ENT_QUOTES, 'UTF-8') . '</span>';
                }
                return $str;
            }else{
                return '';
            }
        }
    }

    if(!function_exists('check_address_proof_status')){
        function check_address_proof_status($kyc){
            if(is_kyc_exists($kyc)){
                if($kyc->address_proof_status == 0){
                    $str = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Pending"><i class="fas fas fa-clock"></i></span>';
                }elseif($kyc->address_proof_status == 1){
                    $str = '<span class="text-success" data-toggle="tooltip" data-placement="top" title="Verified"><i class="fas fa-check-circle"></i></span>';
                }else{
                    $str = '<span class="text-danger" data-toggle="popover" data-content="' . htmlspecialchars($kyc->address_proof_remarks, ENT_QUOTES, 'UTF-8') . '" title="Cancelled"><i class="fas fa-times-circle"></i> '. htmlspecialchars($kyc->address_proof_remarks, ENT_QUOTES, 'UTF-8') .'</span>';
                }
                return $str;
            }else{
                return '';
            }
        }
    }

    if(!function_exists('check_bank_proof_status')){
        function check_bank_proof_status($kyc){
            if(is_kyc_exists($kyc)){
                if($kyc->bank_ac_proof_status == 0){
                    $str = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Pending"><i class="fas fas fa-clock"></i></span>';
                }elseif($kyc->bank_ac_proof_status == 1){
                    $str = '<span class="text-success" data-toggle="tooltip" data-placement="top" title="Verified"><i class="fas fa-check-circle"></i></span>';
                }else{
                    $str = '<span class="text-danger" data-toggle="popover" data-content="' . htmlspecialchars($kyc->bank_ac_proof_remarks, ENT_QUOTES, 'UTF-8') . '" title="Cancelled"><i class="fas fa-times-circle"></i> ' . htmlspecialchars($kyc->bank_ac_proof_remarks, ENT_QUOTES, 'UTF-8') . '</span>';
                }
                return $str;
            }else{
                return '';
            }
        }
    }

    if(!function_exists('check_pan_proof_status')){
        function check_pan_proof_status($kyc){
            if(is_kyc_exists($kyc)){
                if($kyc->pan_card_proof_status == 0){
                    $str = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Pending"><i class="fas fas fa-clock"></i></span>';
                }elseif($kyc->pan_card_proof_status == 1){
                    $str = '<span class="text-success" data-toggle="tooltip" data-placement="top" title="Verified"><i class="fas fa-check-circle"></i></span>';
                }else{
                    $str = '<span class="text-danger" data-toggle="popover" data-content="' . htmlspecialchars($kyc->pan_card_proof_remarks, ENT_QUOTES, 'UTF-8') . '" title="Cancelled"><i class="fas fa-times-circle"></i> ' . htmlspecialchars($kyc->pan_card_proof_remarks, ENT_QUOTES, 'UTF-8') . '</span>';
                }
                return $str;
            }else{
                return '';
            }
        }
    }

    if(!function_exists('check_limit')){
        function check_limit($user_id){
            $user = User::find($user_id);
            if($user){
                $total_amount = TopUp::where('user_id',$user_id)->sum('total_amount');
                $up_to_amount = $total_amount * 10;
                if($up_to_amount == $user->account_balance){
                    return false;
                }elseif($up_to_amount > $user->account_balance){
                    return true;
                }else{
                    return false;
                }

            }
        }
    }

    if(!function_exists('get_user_limit')){
        function get_user_limit($user_id){
            $user = User::find($user_id);
            if($user){
                $total_amount = TopUp::where('user_id',$user_id)->sum('total_amount');
                $up_to_amount = $total_amount * 10;
                return $up_to_amount;
            }else{
                return 0;
            }
        }
    }


    if(!function_exists('update_kyc_status_on_update_profile')){
        function update_kyc_status_on_update_profile($user_id){
            if(Kyc::where('user_id',$user_id)->exists()){
                $kyc = Kyc::where('user_id',$user_id)->first();
                if($kyc->is_confirmed != 1){
                    if($kyc->identy_proof_status != 1){
                        $kyc->identy_proof_status = 0;
                        $kyc->identy_proof_remarks = '';
                    }
                    if($kyc->address_proof_status != 1){
                        $kyc->address_proof_status = 0;
                        $kyc->address_proof_remarks = '';
                    }
                    if($kyc->bank_ac_proof_status != 1){
                        $kyc->bank_ac_proof_status = 0;
                        $kyc->bank_ac_proof_remarks = '';
                    }
                    if($kyc->pan_card_proof_status != 1){
                        $kyc->pan_card_proof_status = 0;
                        $kyc->pan_card_proof_remarks = '';
                    }
                    $kyc->is_confirmed = 0;
                    $kyc->update();
                }
            }
        }
    }


    // if(!function_exists('insertInBinaryTree')){
    //     function insertInBinaryTree($userId, $sponsorId)
    //     {
    //         $sponsorNode = BinaryTree::where('user_id', $sponsorId)->first();

    //         if (!$sponsorNode) {
    //             // If the sponsor doesn't exist, create the first root node
    //             return BinaryTree::create([
    //                 'user_id' => $userId,
    //                 'parent_id' => null,
    //             ]);
    //         }

    //         // BFS to find the first available left/right slot
    //         $queue = [$sponsorNode];

    //         while (!empty($queue)) {
    //             $current = array_shift($queue);

    //             if (is_null($current->left_user_id)) {
    //                 // Ensure the user exists before trying to assign them to the binary tree
    //                 if (User::find($userId)) {
    //                     $newNode = BinaryTree::create([
    //                         'user_id' => $userId,
    //                         'parent_id' => $current->id,
    //                         'position' => 'left',
    //                     ]);
    //                     $current->update(['left_user_id' => $newNode->id]);
    //                     return $newNode;
    //                 }
    //             }

    //             if (is_null($current->right_user_id)) {
    //                 // Ensure the user exists before trying to assign them to the binary tree
    //                 if (User::find($userId)) {
    //                     $newNode = BinaryTree::create([
    //                         'user_id' => $userId,
    //                         'parent_id' => $current->id,
    //                         'position' => 'right',
    //                     ]);
    //                     $current->update(['right_user_id' => $newNode->id]);
    //                     return $newNode;
    //                 }
    //             }

    //             // Queue left and right children for further checking
    //             if ($current->left_user_id) {
    //                 $queue[] = BinaryTree::find($current->left_user_id);
    //             }
    //             if ($current->right_user_id) {
    //                 $queue[] = BinaryTree::find($current->right_user_id);
    //             }
    //         }

    //         return null; // No available slot
    //     }
    // }

    if(!function_exists('insertInBinaryTree')){
        function insertInBinaryTree($userId, $sponsorId)
        {
            $user = User::find($userId);
            if (!$user) {
                return null; // User doesn't exist
            }
    
            // Generate a unique member number (you might want to customize this logic)
            $memberNumber = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
    
            // If no sponsor provided, create as root node
            if (!$sponsorId) {
                return BinaryTree::create([
                    'user_id' => $userId,
                    'member_number' => $memberNumber,
                    'parent_id' => null,
                    'sponsor_id' => null,
                    'status' => 1, // Assuming root is automatically active
                    'activated_at' => now(),
                ]);
            }
    
            $sponsorNode = BinaryTree::where('user_id', $sponsorId)->first();
    
            if (!$sponsorNode) {
                return null; // Sponsor doesn't exist in binary tree
            }
    
            // BFS to find the first available left/right slot
            $queue = [$sponsorNode];
    
            while (!empty($queue)) {
                $current = array_shift($queue);
    
                if (is_null($current->left_user_id)) {
                    $newNode = BinaryTree::create([
                        'user_id' => $userId,
                        'member_number' => $memberNumber,
                        'parent_id' => $current->id,
                        'sponsor_id' => $sponsorId,
                        'position' => 'left',
                        'status' => 0, // Default inactive
                    ]);
                    
                    $current->update(['left_user_id' => $newNode->id]);
                    return $newNode;
                }
    
                if (is_null($current->right_user_id)) {
                    $newNode = BinaryTree::create([
                        'user_id' => $userId,
                        'member_number' => $memberNumber,
                        'parent_id' => $current->id,
                        'sponsor_id' => $sponsorId,
                        'position' => 'right',
                        'status' => 0, // Default inactive
                    ]);
                    
                    $current->update(['right_user_id' => $newNode->id]);
                    return $newNode;
                }
    
                // Queue left and right children for further checking
                if ($current->left_user_id) {
                    $queue[] = BinaryTree::find($current->left_user_id);
                }
                if ($current->right_user_id) {
                    $queue[] = BinaryTree::find($current->right_user_id);
                }
            }
    
            return null; // No available slot
        }
    }
@props(['node', 'currentDepth' => 1, 'maxDepth' => 4])

@if($currentDepth <= $maxDepth)
    <li>
        @if($node)
            <a href="#" wire:click="setAsRoot({{ $node->user_id }})"
               wire:mouseover="$emit('memberDetails', {{ $node->user_id }})">
                <div class="member-view-box n-ppost">
                    <div class="member-header">
                        <span></span>
                    </div>
                    <div class="member-image">
                        <img src="{{ $node->user->profile_photo_url ?? asset('assets/images/treeUser/user.png') }}" 
                             style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;border: 3px solid green;" 
                             alt="Member" class="rounded-circle">
                    </div>
                    <div class="member-footer">
                        <div class="name"><span>{{ $node->user->name }}</span></div>
                        <div class="downline"><span>({{ $node->user_id }})</span></div>
                    </div>
                </div>
                {{-- <div class="n-ppost-name">
                    <div class="element">
                        <label>Name :</label> <strong style="padding-left: 50px;">' . ($user ? $node->user->name : '') . '</strong>
                    </div>
                    <div class="left">
                        <div class="element">
                            <label>Sponsor ID :</label> <strong>' . ($user ? $user->agent_id : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Joining Date :</label> <strong>' . ($user ? formated_date($user->created_at) : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Register (Left) :</label> <strong>' . ($user ? register_left($user->id) : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Activated (Left) :</label> <strong>' . ($user ? activated_left($user->id) : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Total Left :</label> <strong>' . ($user ? total_left($user->id) : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Curr. Left BV :</label> <strong>'.($user ? calculate_curr_left_business($user->id) : '').'</strong>
                        </div>
                        <div class="element">
                            <label>Total Left BV :</label> <strong>'. ($user ? calculate_left_business($user->id) : '') .'</strong>
                        </div>
                        <div class="element">
                            <label>Total User :</label> <strong>' . ($user ? total_user($user->id) : '') . '</strong>
                        </div>
                    </div>
                    <div class="right">
                        <div class="element">
                            <label>Rank :</label> <strong></strong>
                        </div>
                        <div class="element">
                            <label>Confirm Date :</label> <strong></strong>
                        </div>
                        <div class="element">
                            <label>Register (Right) :</label> <strong>' . ($user ? register_right($user->id) : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Activated (Right) :</label> <strong>' . ($user ? activated_right($user->id) : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Total Right :</label> <strong>' . ($user ? total_right($user->id) : '') . '</strong>
                        </div>
                        <div class="element">
                            <label>Curr. Right BV :</label> <strong>'.($user ? calculate_curr_right_business($user->id) : '').'</strong>
                        </div>
                        <div class="element">
                            <label>Total Right BV :</label> <strong>'. ($user ? calculate_right_business($user->id) : '') .'</strong>
                        </div>
                    </div>
                </div> --}}
                <div class="n-ppost-name">
                    <x-user-details-panel :user="$node->user" />
                </div>
            </a>
            
            @if($currentDepth < $maxDepth)
                <ul class="active">
                    {{-- <x-tree-node  --}}
                    <livewire:leaders.tree-partials.tree-node
                        :node="$node->left" 
                        :currentDepth="$currentDepth + 1" 
                        :maxDepth="$maxDepth"
                        wire:key="node-left-{{ $node->user_id }}"
                    />
                    {{-- <x-tree-node  --}}
                    <livewire:leaders.tree-partials.tree-node
                        :node="$node->right" 
                        :currentDepth="$currentDepth + 1" 
                        :maxDepth="$maxDepth"
                        wire:key="node-right-{{ $node->user_id }}"
                    />
                </ul>
            @endif
        @else
            <a href="javascript:void(0);">
                <div class="member-view-box">
                    <div class="member-header">
                        <span></span>
                    </div>
                    <div class="member-image">
                        <img src="{{ asset('assets/images/treeUser/no-user.png') }}" 
                             style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;" 
                             alt="Member" class="rounded-circle">
                    </div>
                    <div class="member-footer">
                        <div class="name"><span>Empty</span></div>
                        <div class="downline"><span>Slot</span></div>
                    </div>
                </div>
            </a>
        @endif
    </li>
@endif
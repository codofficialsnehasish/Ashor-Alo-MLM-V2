@props(['node', 'currentDepth' => 1, 'maxDepth' => 4])

@if($currentDepth <= $maxDepth)
    <li>
        @if($node)
            <a href="javascript:void(0);" wire:click="setAsRoot({{ $node->user_id }})">
                <div class="member-view-box n-ppost">
                    <div class="member-header">
                        <span></span>
                    </div>
                    <div class="member-image">
                        <img src="{{ $node->user->getFirstMediaUrl('profile-image') ?: asset('assets/images/treeUser/user.png') }}" 
                             style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;border: 3px solid {{ $node->status == 1 ? 'green' : 'red' }};" 
                             alt="Member" class="rounded-circle">
                    </div>
                    <div class="member-footer">
                        <div class="name"><span>{{ $node->user->name }}</span></div>
                        <div class="downline"><span>({{ $node->member_number }})</span></div>
                    </div>
                </div>
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
                        <div class="emptyname"><span></span></div>
                    </div>
                </div>
            </a>
            @if($currentDepth < $maxDepth)
                <ul class="active">
                    <livewire:leaders.tree-partials.tree-node
                        :node="null" 
                        :currentDepth="$currentDepth + 1" 
                        :maxDepth="$maxDepth"
                        wire:key="node-left-placeholder-{{ $currentDepth }}"
                    />
                    <livewire:leaders.tree-partials.tree-node
                        :node="null" 
                        :currentDepth="$currentDepth + 1" 
                        :maxDepth="$maxDepth"
                        wire:key="node-right-placeholder-{{ $currentDepth }}"
                    />
                </ul>
            @endif
        @endif
    </li>
@endif
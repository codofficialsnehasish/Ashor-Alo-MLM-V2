@props(['user'])

@if($user)
    <div class="element">
        <label>Name :</label> 
        <strong style="padding-left: 50px;">{{ $user->name }}</strong>
    </div>
    <div class="left">
        <div class="element">
            <label>Sponsor ID :</label> 
            <strong>{{ $user->sponsor?->member_number ?? '' }}</strong>
        </div>
        <div class="element">
            <label>Joining Date :</label> 
            <strong>{{ formated_date($user->created_at) }}</strong>
        </div>
        <div class="element">
            <label>Register (Left) :</label> 
            <strong>{{ $user->binaryNode?->leftUsers->where('status', 0)->count() ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Activated (Left) :</label> 
            <strong>{{ $user->binaryNode?->leftUsers->where('status', 1)->count() ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total Left :</label> 
            <strong>{{ count($user->binaryNode?->leftUsers) ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total User :</label> 
            <strong>{{ (count($user->binaryNode?->leftUsers) + count($user->binaryNode?->rightUsers)) ?? 0 }}</strong>
        </div>
    </div>
    <div class="right">
        <div class="element">
            <label>Rank :</label> 
            <strong>{{ $user->rank ?? 'N/A' }}</strong>
        </div>
        <div class="element">
            <label>Confirm Date :</label> 
            <strong>{{ $user->binaryNode?->activated_at ? formated_date($user->binaryNode?->activated_at) : 'N/A' }}</strong>
        </div>
        <div class="element">
            <label>Register (Right) :</label> 
            <strong>{{ $user->binaryNode?->rightUsers->where('status', 0)->count() ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Activated (Right) :</label> 
            <strong>{{ $user->binaryNode?->rightUsers->where('status', 1)->count() ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total Right :</label> 
            <strong>{{ count($user->binaryNode?->rightUsers) ?? 0 }}</strong>
        </div>
    </div>
@endif
@props(['user'])

@if($user)
<div class="n-ppost-name">
    <div class="element">
        <label>Name :</label> 
        <strong style="padding-left: 50px;">{{ $user->name }}</strong>
    </div>
    <div class="left">
        <div class="element">
            <label>Sponsor ID :</label> 
            <strong>{{ $user->id }}</strong>
        </div>
        <div class="element">
            <label>Joining Date :</label> 
            <strong>{{ $user->created_at->format('d-m-Y') }}</strong>
        </div>
        <div class="element">
            <label>Register (Left) :</label> 
            <strong>{{ $user->register_left ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Activated (Left) :</label> 
            <strong>{{ $user->activated_left ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total Left :</label> 
            <strong>{{ $user->total_left ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Curr. Left BV :</label> 
            <strong>{{ $user->current_left_bv ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total Left BV :</label> 
            <strong>{{ $user->total_left_bv ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total User :</label> 
            <strong>{{ $user->total_users ?? 0 }}</strong>
        </div>
    </div>
    <div class="right">
        <div class="element">
            <label>Rank :</label> 
            <strong>{{ $user->rank ?? 'N/A' }}</strong>
        </div>
        <div class="element">
            <label>Confirm Date :</label> 
            <strong>{{ $user->confirmed_at ? $user->confirmed_at->format('d-m-Y') : 'N/A' }}</strong>
        </div>
        <div class="element">
            <label>Register (Right) :</label> 
            <strong>{{ $user->register_right ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Activated (Right) :</label> 
            <strong>{{ $user->activated_right ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total Right :</label> 
            <strong>{{ $user->total_right ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Curr. Right BV :</label> 
            <strong>{{ $user->current_right_bv ?? 0 }}</strong>
        </div>
        <div class="element">
            <label>Total Right BV :</label> 
            <strong>{{ $user->total_right_bv ?? 0 }}</strong>
        </div>
    </div>
</div>
@endif
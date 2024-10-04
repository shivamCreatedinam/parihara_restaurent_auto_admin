<!DOCTYPE html>
<html lang="EN" xml:lang="en">

<head>
	<title>CcAvenue</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="csrf-param" content="authenticity_token" />
	<meta name="csrf-token"
		content="{{csrf_token()}}" />

	<!--<script src="/assets/application-1e7ed4c05755e1463ebf08d63d19bfdcfaafb8ef6c2e127881df6ff04a3f6551.js"-->
	<!--	data-turbolinks-track="reload"></script>-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" data-turbolinks-track="reload"></script>
</head>

<body>
	<form method="POST" name="customerData" id="myform" action="{{route('submitOrderFOrm')}}"
		style="display: none;">
	    @csrf
		<input type="text" name="merchant_id" value="2840771"/>
		<input type="text" name="amount" value="{{$input['amount']}}"/>
		<input type="text" name="order_id" value="{{$input['order_id']}}"/>
		<input type="text" name="redirect_url" value="{{route('cc-response')}}"/>
		<input type="text" name="cancel_url" value="{{route('cc-response')}}"/>
		<input type="text" name="tid" value="{{$input['tid']}}"/>
        <input type="text" name="billing_name" value="{{$input['billing_name']}}"/>
        <input type="text" name="product_id" value="{{$input['product_id']}}"/>
        <input type="text" name="billing_address" value="{{$input['billing_address']}}"/>
        <input type="text" name="billing_city" value="Unknown"/>
        <input type="text" name="billing_state" value="Unknown"/>
        <input type="text" name="billing_zip" value="{{$input['billing_zip']}}"/>
        <input type="text" name="billing_country" value="{{$input['billing_country']}}"/>
        <input type="text" name="billing_tel" value="{{$input['billing_tel']}}"/>
        <input type="text" name="billing_email" value="{{$input['billing_email']}}"/>
        <input type="text" name="delivery_name" value="{{$input['delivery_name']}}"/>
        <input type="text" name="delivery_address" value="{{$input['delivery_address']}}"/>
        <input type="text" name="delivery_city" value="{{$input['delivery_city']}}"/>
        <input type="text" name="delivery_state" value="{{$input['delivery_state']}}"/>
        <input type="text" name="delivery_zip" value="{{$input['delivery_zip']}}"/>
        <input type="text" name="delivery_tel" value="{{$input['delivery_tel']}}"/>
        <input type="text" name="delivery_country" value="{{$input['delivery_country']}}"/>
		<input type="text" name="currency" value="INR"/>
		<input type="text" name="language" value="EN"/>
		<input type="text" name="promo_code" value=""/>
		<input type="text" name="customer_identifier" value=""/>
		<input type="text" name="integration_type" value="iframe_normal"/>
		<INPUT TYPE="submit" value="CheckOut">
</form>
		<script type="text/javascript">
            $(document).ready(function(){
                setTimeout(function() {
                  $("form").submit();
                }, 1000);
              });
		</script>

</body>

</html>
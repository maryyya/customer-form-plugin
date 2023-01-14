# customer-form-plugin

# Customer Form Plugin

## What I did:

1. Created a plugin called `customer-form`.
2. Inside that plugin, I created a shortcode with attributes that can be used as `[customer_form]`.
3. I added a default value for those shortcode attributes incase there are no attributes or they are empty.
4. These attributes can change the input labels, maxlength value and message's rows&cols.

## customer_form shortcode attributes:

* name_label
* name_maxlength
* number_label
* number_maxlength
* email_label
* email_maxlength
* budget_label
* budget_maxlength
* message_label
* message_maxlength
* message_rows
* message_cols

## customer_form Shortcode Sample:
1. Just put the shortcode on a post or page with or without attributes. You can change the labels, maxlength and message's rows&cols by adding the attributes. If max length is empty then there is no maxlength.

### Without attributes:
```php
[customer_form]
```

### With attributes:
```php
[customer_form name_label="Full Name" name_maxlength="100" number_label="Phone Number" number_maxlength="100" email_label="Email Address" email_maxlength="100" budget_label="Desired Budger" budget_maxlength="100" message_label="Message" message_maxlength="100" message_rows="10" message_cols="6"]
```

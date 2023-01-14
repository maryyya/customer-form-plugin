# customer-form-plugin

# Customer Form Plugin

## What I did:

1. Created a plugin called `customer-form`.
2. Inside that plugin, I created a shortcode with attributes that can be used as `[customer_form]`.
3. I added a default value for those shortcode incase there are no attributes or they are empty.

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

### Without attributes:
```[customer_form]```

### With attributes:
```php
[customer_form name_label="Full Name" name_maxlength="9" number_label="Phone Number" number_maxlength="8" email_label="Email Address" email_maxlength="8" budget_label="Desired Budger" budget_maxlength="10" message_label="Message" message_maxlength="8" message_rows="10" message_cols="6"]
```


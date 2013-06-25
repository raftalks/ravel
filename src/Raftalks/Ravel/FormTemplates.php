<?php

Xform::decorate('text',function($textInput)
{
	$textInput->class('text-input');
});

Xform::decorate('password',function($textInput)
{
	$textInput->class('text-input');
});



Xhtml::macro('box_panel',function($title, $callback)
{
	return Xform::template('div',function($div) use($title, $callback)
	{

		$div->div(function($div) use($title)
		{
			$div->h3($title);
			$div->setClass('content-box-header');
		});

		$div->div(function($div) use($callback)
		{
			$callback($div);
			$div->setClass('content-box-content');
		});

		$div->setCLass('content-box');
	});
});


Xhtml::macro('content_panel',function($title, $callback, $toolbarCallback = null)
{
	return Xform::template('div',function($div) use($title, $callback, $toolbarCallback)
	{

		$div->div(function($div) use($title)
		{
			$div->h3($title);

			// $div->div(function($div)
			// {
			// 	$div->button('create')->class('button');

			// 	$div->setClass('align-right');
			// });

			$div->setClass('content-box-header');
		});

		$div->div(function($div) use($callback, $toolbarCallback)
		{
			if(!is_null($toolbarCallback))
			{
				$div->div(function($div) use($toolbarCallback)
	            {
	                  $toolbarCallback($div);
	                  $div->setClass('toolbar');
	            });

			}
			
			$callback($div);
			$div->setClass('content-box-content');
		});

		$div->setCLass('content-box');
	});
});



Xform::macro('box_panel',function($title, $callback)
{
	$macro = Xhtml::getMacro('box_panel');
	return $macro($title, $callback);
});





function get_form_error_message($form, $name, $format=':message')
{
	$errors = $form->get_errors();
	$error_message = null;

	if(!is_null($errors) && is_object($errors))
	{
		if($errors->has($name))
		{
			$error_message = $errors->first($name,':message');
		}
	}

	return $error_message;
}


function have_error($form, $name)
{
	$errors = $form->get_errors();
	if(!is_null($errors) && is_object($errors))
	{
		return $errors->has($name);
		
	}

	return false;
}



Xform::include_all(function()
{
	return Xform::template('div',function($form)
	{
		$form->hidden('csrf_token')->value(Session::getToken());
		$form->setClass('token');
	});
});



Xform::macro('show_input_error',function($name, $message=null)
{
	return Xform::template('span',function($form) use($name, $message)
	{
		$error_message = get_form_error_message($form, $name);			

		if(!is_null($error_message))
		{
			
			$form->putText($error_message);
			//$form->setRootAttr('data-title',$error_message);
			$form->setClass('help-block text-error');
		}
		else
		{
			
			$form->putText($message);

			$form->setClass('help-block');
		}
		
	});
});


Xform::macro('break',function()
{
	return Xform::template('br',function($form)
	{

	});
});


Xform::macro('input_textarea', function($name, $label, $value=null, $attr = array())
{
	if(is_null($value) || $value =='')
	{
		$value = Input::old($name);
	}

	return Xform::template('div',function($form) use ($name, $label, $attr, $value)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');

		}
		$form->label($label)->for($name);
		$form->textarea($name)->value($value)->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});
});



Xform::macro('input_number', function($name, $label, $value=null, $attr = array())
{
	if(is_null($value) || $value =='')
	{
		$value = Input::old($name);
	}

	return Xform::template('div',function($form) use ($name, $label, $attr, $value)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');

		}
		//$form->label($label)->for($name);
		$form->number($name)->placeholder($label)->value($value)->step('any')->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});
});






Xform::macro('input_text', function($name, $label, $value=null, $attr = array())
{
	if(is_null($value) || $value =='')
	{
		$value = Input::old($name);
	}

	return Xform::template('div',function($form) use ($name, $label, $attr, $value)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');

		}
		//$form->label($label)->for($name);
		$form->text($name)->placeholder($label)->value($value)->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});
});








Xform::macro('input_text_fill', function($name, $label, $value=null, $attr = array())
{
	if(is_null($value) || $value =='')
	{
		$value = Input::old($name);
	}

	return Xform::template('div',function($form) use ($name, $label, $attr, $value)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');

		}

		$form->text($name)->placeholder($label)->value($value)->class('fill-up')->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});
});




Xform::macro('input_text_small', function($name, $label, $value=null, $attr = array())
{
	if(is_null($value) || $value =='')
	{
		$value = Input::old($name);
	}

	return Xform::template('div',function($form) use ($name, $label, $attr, $value)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');
		}

		$form->text($name)->placeholder($label)->value($value)->class('input-small')->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});

});



Xform::macro('input_text_large', function($name, $label, $value=null, $attr = array())
{
	if(is_null($value) || $value =='')
	{
		$value = Input::old($name);
	}

	return Xform::template('div',function($form) use ($name, $label, $attr, $value)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');
		}

		$form->text($name)->placeholder($label)->value($value)->class('span4')->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});

});



//input password field types
Xform::macro('input_password', function($name, $label, $attr = array())
{
	
	return Xform::template('div',function($form) use ($name, $label, $attr)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');
		}

		$form->password($name)->placeholder($label)->value(null)->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});
});





Xform::macro('input_password_fill', function($name, $label,  $attr = array())
{

	return Xform::template('div',function($form) use ($name, $label, $attr)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');
		}

		$form->password($name)->placeholder($label)->value(null)->class('fill-up')->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});
});







Xform::macro('input_checkbox', function($name, $label, $checked=false, $attr = array())
{
	if($checked)
	{
		$attr['checked'] = true;
	}
	
	return Xform::template('div',function($form) use ($name, $label, $attr)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');
		}

		$form->checkbox($name)->setAttributes($attr);
		
		if(isset($attr['id']))
		{
			$form->label($label)->for($attr['id']);
		} else
		{
			$form->span($label);
		}

		$form->show_input_error($name);

		$form->setClass('input');
	});
});





Xform::macro('input_radio', function($name, $label, $checked=false, $attr = array())
{
	if($checked)
	{
		$attr['checked'] = true;
	}
	
	return Xform::template('div',function($form) use ($name, $label, $attr)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');
		}

		$form->radio($name)->class('normal-radio')->setAttributes($attr);
		
		if(isset($attr['id']))
		{
			$form->label($label)->for($attr['id']);
		} else
		{
			$form->span($label);
		}

		$form->show_input_error($name);

		$form->setClass('input');
	});
});





Xform::macro('submit_actions',function($submitName='Submit', $CancelBt=true, $attr=array())
{

	return Xform::template('div',function($form) use ($submitName, $CancelBt, $attr)
	{
		$form->submit($submitName)->class('button blue')->setAttributes($attr);
		if($CancelBt)
		{
			$returnUrl = Request::url();	
			$form->a('Cancel')->class('button')->href($returnUrl);
			
		}
	
		$form->setClass('form-actions');
	});

});


Xform::macro('ng_submit_actions',function($submitName='Submit', $CancelBt=true, $attr=array())
{

	return Xform::template('div',function($form) use ($submitName, $CancelBt, $attr)
	{
		$form->submit($submitName)->class('btn btn-primary')->setAttributes($attr);
		if($CancelBt)
		{
			
			$form->button('Cancel')->class('btn')->ng_click('cancel()','ng-click');
			
		}
	
		$form->setClass('form-actions');
	});

});






Xform::macro('datepicker', function($name, $label=null, $value=null, $attr = array(), $type = 'date')
{
	if(is_null($value) || $value =='')
	{
		$value = Input::old($name);
	}

	return Xform::template('div',function($form) use ($name, $label, $attr, $value, $type)
	{
		if(have_error($form, $name))
		{
			$attr['class']='error';
			$form->setClass('error');

		}

		if(!is_null($label))
		{
			$form->label($label);
		}
		
		$form->$type($name)->placeholder($label)->value($value)->class('input-medium')->setAttributes($attr);
		$form->show_input_error($name);

		$form->setClass('input');
	});

});


Xform::macro('ng_datepicker',function($name, $label, $ng_model, $value = null, $attr = null)
{
	return Xform::template('div',function($form) use ($name, $label, $ng_model, $value, $attr)
	{
		if(is_null($attr))
		{
			$attr = array();
		}

		if(!is_null($value))
		{
			$attr['value'] = $value;
		}

		$form->ngdatepicker('publish_date',$label)->ng_model($ng_model,'ng-model')->formatteddate('short')->setAttributes($attr);

	});
});

Xform::macro('label_value', function($label, $value, $attr = array())
{
	return Xform::template('div', function($form) use($label, $value, $attr)
	{
		$form->label($label);
		$form->span($value)->setAttributes($attr);
		$form->setClass('input_value');
	});
});


Xform::macro('multi_select',function($name, $label, $options, $value=null, $attr=array())
{
	return Xform::template('div',function($form) use($name, $label, $options, $value, $attr)
	{
		$form->select($name, $label)->options($options, $value)->multiple(true)->setAttributes($attr);
	});
});


Xform::macro('ng_multi_select', function($name, $label, $ng_model, $ng_options, $attr=array())
{
	return Xform::template('div', function($form) use($name, $label, $ng_model, $ng_options, $attr)
	{
		$form->setClass('fill-up');
		$ng_options = 'xitem.id as xitem.name for xitem in '.$ng_options;
		$form->select($name, $label)->select2('','ui-select2')->ng_options($ng_options,'ng-options')->ng_model($ng_model, 'ng-model')->class('ng_multi_select')->multiple(null)->setAttributes($attr);

	});
});



Xform::macro('input_select',function($name, $label, $options, $value=null, $attr=array())
{
	return Xform::template('div',function($form) use($name, $label, $options, $value, $attr)
	{
		$form->select($name, $label)->options($options, $value)->setAttributes($attr);
	});
});


Xform::macro('ng_toolbar',function($buttons)
{
	return Xform::template('div',function($form) use($buttons)
	{
		foreach($buttons as $btnLabel => $btnAction)
		{
				$form->button($btnLabel)->ng_click($btnAction,'ng-click')->class('btn');
		}

		$form->setClass('panel-toolbar btn-group');
	});
});


//Accordion Template

Xform::macro('acc_heading',function($parent_id, $link, $heading)
{
	return Xform::template('div',function($form)use($parent_id, $link, $heading)
	{
		$form->a(function($a) use ($heading, $parent_id, $link)
		{
			$a->putText($heading);
			$a->setClass('accordion-toggle');
			$a->setDataToggle('collapse','data-toggle');
			$a->setDataParent('#'.$parent_id ,'data-parent');
			$a->setHref('#'.$link);

		});
		$form->setClass('accordion-heading');
	});
});



Xform::macro('acc_group',function($parent_id, $group_id, $heading, $callback, $open)
{
	return Xform::template('div',function($form)use($parent_id, $group_id, $heading, $callback, $open)
	{

		$form->acc_heading($parent_id, $group_id, $heading);
		$form->div(function($div) use ($callback, $parent_id, $group_id, $heading, $open)
		{
			

			$div->div(function($div) use($callback)
			{
				$callback($div);
				$div->setClass('accordion-inner');
			});

			$div->setId($group_id);

			$addClass = '';
			if($open)
			{
				$addClass='in';
			}
			$div->setClass('accordion-body collapse '.$addClass);
		});

		
		$form->setClass('accordion-group');
	});
});



Xform::macro('accordion',function($container_id, $data)
{

		return Xform::template('div',function($form) use ($data, $container_id)
		{
			$accord_id = $container_id.'_accod';
			$i = 1;
			foreach($data as $heading => $callback)
			{
				$group_id = $accord_id . $i;
				$open = ($i == 1);

					$form->acc_group($container_id, $group_id, $heading, $callback, $open);

				$i++;
			}

			$form->setId($container_id);
			$form->setClass('accordion');
		});
		
});


//layout panels

Xform::macro('sub_section',function($title, $callback)
{

	return Xform::template('div',function($form) use($title, $callback)
	{
		$form->h4($title);
		$form->hr();
		$form->div(function($form) use ($callback)
		{
			$callback($form);
			$form->setClass('span12');
		});
		
		$form->setClass('row-fluid');

	});
});


//Custom Fields panel
Xform::macro('custom_field', function($name, $attr)
{
	return Xform::template('div', function($form) use ($name, $attr)
	{
		$label = isset($attr['label']) ? $attr['label'] : null;
		$fieldType = isset($attr['type']) ? $attr['type'] : 'text';
		$options = isset($attr['options']) ? $attr['options'] : array();
		$attributes = isset($attr['attr']) ? $attr['attr'] : array();
		

		switch($fieldType)
		{
			case 'ng_datepicker':	
				$customField = true;
				$model = isset($attributes['ng-model']) ? $attributes['ng-model'] : 'item.'.$name;
				$form->ng_datepicker($name, $label, $model, null, $attributes);
			break;

			case 'datepicker':
				$customField = true;
				$form->datepicker($name, $label, null, $attributes);
			break;

			case 'input_select':
				$customField = true;
				$form->input_select($name, $label, $options, null, $attributes);
			break;

			case 'multi_select':
				$customField = true;
				$form->multi_select($name, $label, $options, null, $attributes);
			break;

			case 'input_radio':
				$customField = true;
				$form->input_radio($name, $label, false, $attributes);
			break;


			case 'input_checkbox':
				$customField = true;
				if(isset($attributes['ng-model']))
				{
					$ngmodel = $attributes['ng-model'];
					$attributes['ng-true-value'] = '1';
					$attributes['ng-false-value'] = '0';
					$attributes['ng-checked'] = "$ngmodel == 1";
				}

				$form->input_checkbox($name, $label, false, $attributes);
			break;

			case 'input_password_fill':
				$customField = true;
				$form->input_password_fill($name, $label, false, $attributes);
			break;

			case 'input_password':
				$customField = true;
				$form->input_password($name, $label, $attributes);
			break;

			case 'input_text_large':
			case 'input_text_small':
			case 'input_text_fill':
			case 'input_text':
			case 'input_number':
			case 'input_textarea':
				$customField = true;
				$form->$fieldType($name, $label, null, $attributes);
			break;


			default:
				$customField = false;
			break;
		}

		if($customField == false)
		{
			if(!empty($options))
			{
				$form->$fieldType($name, $label)->options($options)->setAttributes($attributes);
			} else
			{
				$form->$fieldType($name, $label)->setAttributes($attributes);
			}
		}
		
		
	});

});



Xform::macro('custom_fields', function($fields)
{
	return Xform::template('div',function($form) use ($fields)
	{
			foreach($fields as $name => $attr)
			{
				$form->custom_field($name, $attr, false);
			}
	});
});


Xform::macro('ng_custom_fields', function($fields, $angularRootItem = 'item')
{
	return Xform::template('div',function($form) use ($fields, $angularRootItem)
	{
			foreach($fields as $name => $attr)
			{
				if(is_array($attr))
				{
					if(!isset($attr['attr']))
					{
						$attr['attr'] = array();
					}

					if(!isset($attr['attr']['ng-model']))
					{
						$attr['attr']['ng-model'] = $angularRootItem .'.'.$name;
					}

				}
				

				$form->custom_field($name, $attr);
			}
	});
});


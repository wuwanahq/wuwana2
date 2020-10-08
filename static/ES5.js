// ECMAScript 5
'use strict';

for (var i = 0; i < 99; ++i)
{
	var input1 = document.getElementById('C' + i);
	var input2 = document.getElementById('R' + i);

	//TODO:
	var debug1 = input1.style.display;
	var debug2 = input2.style.display;

	if (input1 != null)
	{
		input1.addEventListener('change', function() {
			this.form.submit();
		});
	}

	if (input2 != null)
	{
		input2.addEventListener('change', function() {
			this.form.submit();
		});
	}

	if (input1 == null && input2 == null)
	{ break; }
}
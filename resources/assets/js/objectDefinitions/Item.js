import { Record } from 'immutable';

export const Item = new Record({
	id: undefined,
	crew_id: undefined,
	parent_id: undefined,
	serial_number: undefined,
	quantity: undefined,
	type: undefined,
	category: 'Uncategorized',
	color: undefined,
	size: undefined,
	condition: undefined,
	checked_out_to_id: undefined,
	checked_out_to_type: undefined,
	note: '',
	usable: 1,
	restock_trigger: undefined,
	restock_to_quantity: undefined,
	source: undefined,
	created_at: undefined,
	updated_at: undefined,
});

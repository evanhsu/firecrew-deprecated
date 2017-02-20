export function itemCategories() {
	return {
		'GPS Units': {
			name: 'GPS Units',
			items: [
				{
					id: 1,
					quantity: null,
					category: 'GPS Units',
					description: 'Garmin 76ST',
					serial_number: 'jfur30k1',
				},
				{
					id: 2,
					quantity: null,
					category: 'GPS Units',
					description: 'Garmin 60',
					serial_number: '884j99f',
				},
			]
		},
		'Nomex Pants': {
			name: 'Nomex Pants',
			items: [
				{
					id: 3,
					quantity: 4,
					category: 'Nomex Pants',
					description: 'Standard GSA',
					size: '30-34 Regular',
					serial_number: null,
				},
				{
					id: 4,
					quantity: 2,
					category: 'Nomex Pants',
					description: 'Standard GSA',
					size: '35-39 Short',
					serial_number: null,
				},
			]
		},
	};
}

export function selectedItemCategory() {
	return 'Nomex Pants';
}

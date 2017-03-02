import { combineReducers } from 'redux-immutable';

import { categoryMenuDrawerOpen, selectedItemCategory } from './navigationReducer';
import { items } from './itemsReducer';
import { categories } from './categoriesReducer';
import { selectedItemRow } from './selectedItemRowReducer';

const rootReducer = combineReducers({
	categories: categories,
	categoryMenuDrawerOpen: categoryMenuDrawerOpen,
	items: items,
	selectedItemCategory: selectedItemCategory,
	selectedItemRow: selectedItemRow,
});

export default rootReducer;

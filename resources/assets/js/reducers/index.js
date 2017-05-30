import { combineReducers } from 'redux-immutable';

import { categoryMenuDrawerOpen, selectedItemCategory } from '../containers/App/reducer';
import { items } from '../containers/CategoryItemsTable/itemsReducer';
import { categoriesReducer } from '../containers/CategoryItemsTable/categoriesReducer';
import { selectedItemRowReducer } from '../containers/CategoryItemsTable/selectedItemRowReducer';
import { reducer as formReducer } from 'redux-form/immutable';
import { routerReducer } from 'react-router-redux'

 const rootReducer = combineReducers({
	categories: categoriesReducer,
	categoryMenuDrawerOpen: categoryMenuDrawerOpen,
    form: formReducer,
	items: items,
    router: routerReducer,
	selectedItemCategory: selectedItemCategory,
	selectedItemRow: selectedItemRowReducer,
});

export default rootReducer;

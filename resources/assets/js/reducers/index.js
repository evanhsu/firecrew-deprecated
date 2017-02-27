import { combineReducers } from 'redux-immutable';
import { List, Map } from 'immutable';

// import { categoryMenuDrawerOpen } from './navigationReducer';
import { items } from './itemsReducer';
// import { loading } from './loadingReducer';

const rootReducer = combineReducers({
	// categoryMenuDrawerOpen: categoryMenuDrawerOpen,
	items: items,
	// loading: loading,
});

export default rootReducer;

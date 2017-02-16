require('./bootstrap');
import injectTapEventPlugin from 'react-tap-event-plugin';


import Example from './components/Example';


// Needed for onTouchTap (Material-UI)
// http://stackoverflow.com/a/34015469/988941
injectTapEventPlugin();
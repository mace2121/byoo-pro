import './bootstrap';

import Alpine from 'alpinejs';
import DesignEditorShared from './design-editor-shared';
import Shepherd from 'shepherd.js';
import 'shepherd.js/dist/css/shepherd.css';

window.Alpine = Alpine;
window.DesignEditorShared = DesignEditorShared;
window.Shepherd = Shepherd;

Alpine.start();

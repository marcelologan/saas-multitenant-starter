import './bootstrap';

import Alpine from 'alpinejs';
import './admin/user-management.js';
import './admin/role-management.js';
import './admin/admin-panel.js';
import './admin/permission-management.js'; 
import './themes/theme-switcher.js';

window.Alpine = Alpine;

Alpine.start();

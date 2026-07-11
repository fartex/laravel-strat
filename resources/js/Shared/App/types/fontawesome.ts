import { config, library } from '@fortawesome/fontawesome-svg-core';
import { faBell, faBook, faCaretRight, faCircle, faGear } from '@fortawesome/free-solid-svg-icons';
import { faHouse } from '@fortawesome/free-regular-svg-icons';
import { faGithub } from '@fortawesome/free-brands-svg-icons';

config.autoAddCss = false;

library.add(faBell, faBook, faCaretRight, faCircle, faGear, faHouse, faGithub);

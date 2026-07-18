import { config, library } from '@fortawesome/fontawesome-svg-core';
import {
    faBell,
    faBook,
    faGear,
    faTable,
    faCircle,
    faRotate,
    faCaretRight,
    faChevronLeft,
    faChevronRight,
} from '@fortawesome/free-solid-svg-icons';
import { faGithub } from '@fortawesome/free-brands-svg-icons';

config.autoAddCss = false;

library.add(
    faBell,
    faBook,
    faGear,
    faTable,
    faGithub,
    faRotate,
    faCircle,
    faCaretRight,
    faChevronLeft,
    faChevronRight,
);

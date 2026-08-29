import { createI18n } from 'vue-i18n';

// ** Local Imports
import { LocaleEnum } from '@shared/App/enum';
import ptBR from '@shared/Lang/pt-BR.json';
import ptBREnum from '@shared/Lang/Enum/pt-BR.json';
import enUS from '@shared/Lang/en-US.json';
import enUSEnum from '@shared/Lang/Enum/en-US.json';

export default createI18n({
    legacy: false,
    locale: LocaleEnum.EN_US,
    fallbackLocale: LocaleEnum.EN_US,
    messages: {
        [LocaleEnum.PT_BR]: { ...ptBR, ...ptBREnum },
        [LocaleEnum.EN_US]: { ...enUS, ...enUSEnum },
    },
});

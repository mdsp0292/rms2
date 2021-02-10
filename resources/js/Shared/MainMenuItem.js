import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';
import classNames from 'classnames';
import Icon from '@/Shared/Icon';

export default ({ icon, link, text }) => {
  const isActive = route().current(link + '*');

  const iconClasses = classNames('w-4 h-4 mr-2', {
    'text-white fill-current': isActive,
    'text-geyser-500 group-hover:text-white fill-current': !isActive
  });

  const textClasses = classNames({
    'text-geyser-500 text-sm font-semibold': isActive,
    'text-geyser-500 text-sm font-semibold group-hover:text-white': !isActive
  });

  return (
    <div className="mb-4">
      <InertiaLink href={route(link)} className="flex items-center group ">
          <span className={iconClasses}>{icon}</span>
        <div className={textClasses}>{text}</div>
      </InertiaLink>
    </div>
  );
};

import React, { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-react';
import { usePrevious } from 'react-use';
import pickBy from 'lodash/pickBy';

export default () => {
  const { filters } = usePage().props;
  const [opened, setOpened] = useState(false);

  const [values, setValues] = useState({
      search: filters.search || ''
  });

  const prevValues = usePrevious(values);

  function reset() {
    setValues({
        search: ''
    });
  }

  useEffect(() => {
    if (prevValues) {
      const query = Object.keys(pickBy(values)).length
        ? pickBy(values)
        : { remember: 'forget' };
        Inertia.get(route(route().current()), query, {
            replace: true,
            preserveState: true
        });
    }
  }, [values]);

  function handleChange(e) {
    const key = e.target.name;
    const value = e.target.value;

    setValues(values => ({
      ...values,
      [key]: value
    }));

    if (opened) setOpened(false);
  }

  return (
    <div className="flex items-center w-full max-w-md mr-4">
      <div className="relative flex w-full bg-white shadow rounded">
        <input
          className="relative w-full px-6 py-3 focus:outline-none focus:shadow-xl"
          autoComplete="off"
          type="text"
          name="search"
          value={values.search}
          onChange={handleChange}
          placeholder="Search…"
        />
      </div>
      <button
        onClick={reset}
        className="ml-3 text-sm text-gray-600 hover:text-gray-700 focus:text-indigo-700 focus:outline-none"
        type="button"
      >
        Reset
      </button>
    </div>
  );
};

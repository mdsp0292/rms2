import React, { useState } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-react';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';

export default () => {
  const { errors } = usePage().props;
  const [sending, setSending] = useState(false);
  const [values, setValues] = useState({
    email: '',
    password: '',
    remember: false
  });

  function handleChange(e) {
    const key = e.target.name;
    const value =
      e.target.type === 'checkbox' ? e.target.checked : e.target.value;

    setValues(values => ({
      ...values,
      [key]: value
    }));
  }

  function handleSubmit(e) {
    e.preventDefault();
    setSending(true);
    Inertia.post(route('login.attempt'), values, {
      onFinish: () => setSending(false)
    });s
  }

  return (
    <div className="flex items-center justify-center min-h-screen p-6 bg-mirage-300">
      <Helmet title="Login" />
      <div className="w-full max-w-md">

        <form
          onSubmit={handleSubmit}
          className="mt-8 overflow-hidden bg-white rounded-lg shadow-xl"
        >
          <div className="px-10 py-12">
            <h1 className="text-3xl font-bold text-center"> RMS </h1>
            <div className="w-24 mx-auto mt-6 border-b-2" />
            <TextInput
              className="mt-10"
              label="Email"
              name="email"
              type="email"
              errors={errors.email}
              value={values.email}
              onChange={handleChange}
            />
            <TextInput
              className="mt-6"
              label="Password"
              name="password"
              type="password"
              errors={errors.password}
              value={values.password}
              onChange={handleChange}
            />
            <label
              className="flex items-center mt-6 select-none"
              htmlFor="remember"
            >
              <input
                name="remember"
                id="remember"
                className="mr-1"
                type="checkbox"
                checked={values.remember}
                onChange={handleChange}
              />
              <span className="text-sm">Remember Me</span>
            </label>
          </div>
          <div className="flex items-center justify-between px-10 py-4 bg-gray-100 border-t border-gray-200">
            <a className="hover:underline" tabIndex="-1" href="#reset-password">
              Forgot password?
            </a>
            <LoadingButton
              type="submit"
              loading={sending}
              className="btn-indigo"
            >
              Login
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

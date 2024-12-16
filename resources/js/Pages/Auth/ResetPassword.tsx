import InputError from '@/Components/Core/InputError';
import InputLabel from '@/Components/Core/InputLabel';
import PrimaryButton from '@/Components/Core/PrimaryButton';
import TextInput from '@/Components/Core/TextInput';
import {Head, useForm} from '@inertiajs/react';
import {FormEventHandler} from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function ResetPassword({
                                        token,
                                        email,
                                      }: {
  token: string;
  email: string;
}) {
  const {data, setData, post, processing, errors, reset} = useForm({
    token: token,
    email: email,
    password: '',
    password_confirmation: '',
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('password.store'), {
      onFinish: () => reset('password', 'password_confirmation'),
    });
  };

  return (
    <AuthenticatedLayout>
      <Head title="Reset Password"/>
      <div className={"p-8"}>
        <div className="card bg-white dark:bg-gray-800 shadow max-w-[420px] mx-auto">
          <div className="card-body">

            <h1 className={"text-2xl mb-6 text-center"}>Reset your password</h1>

            <form onSubmit={submit}>
              <div>
                <InputLabel htmlFor="email" value="Email"/>

                <TextInput
                  id="email"
                  type="email"
                  name="email"
                  value={data.email}
                  className="mt-1 block w-full"
                  autoComplete="username"
                  onChange={(e) => setData('email', e.target.value)}
                />

                <InputError message={errors.email} className="mt-2"/>
              </div>

              <div className="mt-4">
                <InputLabel htmlFor="password" value="Password"/>

                <TextInput
                  id="password"
                  type="password"
                  name="password"
                  value={data.password}
                  className="mt-1 block w-full"
                  autoComplete="new-password"
                  isFocused={true}
                  onChange={(e) => setData('password', e.target.value)}
                />

                <InputError message={errors.password} className="mt-2"/>
              </div>

              <div className="mt-4">
                <InputLabel
                  htmlFor="password_confirmation"
                  value="Confirm Password"
                />

                <TextInput
                  type="password"
                  name="password_confirmation"
                  value={data.password_confirmation}
                  className="mt-1 block w-full"
                  autoComplete="new-password"
                  onChange={(e) =>
                    setData('password_confirmation', e.target.value)
                  }
                />

                <InputError
                  message={errors.password_confirmation}
                  className="mt-2"
                />
              </div>

              <div className="mt-4 flex items-center justify-end">
                <PrimaryButton className="ms-4" disabled={processing}>
                  Reset Password
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

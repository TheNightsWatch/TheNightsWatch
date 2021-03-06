<?php

class DeserterCommand extends CConsoleCommand
{
    public function actionAdd($user,$reason = null,$server = "minez-nightswatch.com",$proof = null,$warrant = false)
    {
        $u = User::model()->findByAttributes(array('ign' => $user));
        if(!$u) $this->usageError("The user {$user} does not exist in our database.");

        $u->deserter = User::DESERTER_DESERTER;
        $u->save();

        $kos = KOS::model()->findByAttributes(array('ign' => $user));
        if(!$kos)
        {
            $kos = new KOS;
            $kos->ign = $user;
        }
        $kos->status = $warrant ? KOS::STATUS_WARRANT : KOS::STATUS_DESERTER;
        $kos->save();
	if($reason !== null)
	{
            $r = new KOSReport;
            $r->kosID = $kos->id;
            $r->reporterID = User::model()->findByAttributes(array('ign' => 'Navarr'))->id;
            $r->report = $reason;
            $r->proof = $proof;
            $r->save();
        }
    }
}
